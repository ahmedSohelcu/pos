<?php

namespace Modules\Sales\App\Services;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Inventory\App\Services\StockService;
use Modules\Product\App\Models\ProductVariant;
use Modules\Sales\App\Models\Sale;

class SaleService
{
    public function __construct(private StockService $stockService) {}

    public function getAll()
    {
        return Sale::query()
            ->with(['customer:id,name', 'cashier:id,name'])
            ->withCount('items')
            ->when(request('search'), function ($q) {
                $term = '%' . request('search') . '%';
                $q->where(function ($qq) use ($term) {
                    $qq->where('reference', 'like', $term)
                        ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', $term));
                });
            })
            ->when(request('status'), fn ($q) => $q->where('status', request('status')))
            ->when(request('payment_method'), fn ($q) => $q->where('payment_method', request('payment_method')))
            ->when(request('date_from'), fn ($q) => $q->whereDate('created_at', '>=', request('date_from')))
            ->when(request('date_to'), fn ($q) => $q->whereDate('created_at', '<=', request('date_to')))
            ->orderByDesc('id')
            ->paginate(request('per_page', 10))
            ->withQueryString();
    }

    public function create(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            $variantIds = collect($data['items'])->pluck('product_variant_id')->unique();

            $variants = ProductVariant::query()
                ->with('product:id,name,track_stock')
                ->lockForUpdate()
                ->whereIn('id', $variantIds)
                ->get()
                ->keyBy('id');

            $lines = [];
            $subtotal = 0;

            foreach ($data['items'] as $row) {
                $variant = $variants[$row['product_variant_id']] ?? null;

                if (! $variant) {
                    throw ValidationException::withMessages([
                        'items' => "Variant #{$row['product_variant_id']} not found",
                    ]);
                }

                $qty = (float) $row['quantity'];
                if ($qty <= 0) {
                    throw ValidationException::withMessages([
                        'items' => "Quantity must be greater than zero",
                    ]);
                }

                if ($variant->product?->track_stock && $qty > (float) $variant->stock) {
                    abort(422, "Insufficient stock for {$variant->name} ({$variant->stock} available)");
                }

                $unit = (float) $variant->sale_price;
                $lineTotal = round($unit * $qty, 2);
                $subtotal += $lineTotal;

                $lines[] = [
                    'variant' => $variant,
                    'quantity' => $qty,
                    'unit_price' => $unit,
                    'total' => $lineTotal,
                ];
            }

            $requestedType = $data['discount_type'] ?? 'fixed';
            $discountType = in_array($requestedType, ['fixed', 'percent']) ? $requestedType : 'fixed';
            $discountValue = max(0, (float) ($data['discount_value'] ?? 0));

            if ($discountType === 'percent') {
                $discountValue = min($discountValue, 100);
                $discountAmount = round($subtotal * $discountValue / 100, 2);
            } else {
                $discountAmount = min($discountValue, $subtotal);
            }

            $total = round(max($subtotal - $discountAmount, 0), 2);

            $method = in_array($data['payment_method'] ?? 'cash', ['cash', 'card', 'mobile'])
                ? $data['payment_method']
                : 'cash';

            $tendered = (float) ($data['amount_tendered'] ?? 0);
            $changeDue = 0.0;

            if ($method === 'cash') {
                if ($tendered < $total) {
                    abort(422, 'Insufficient amount tendered');
                }
                $changeDue = round($tendered - $total, 2);
            } else {
                $tendered = $total;
            }

            /** @var User|null $user */
            $user = auth()->user();

            $openShiftId = class_exists(\Modules\Register\App\Models\RegisterShift::class)
                ? \Modules\Register\App\Models\RegisterShift::query()->open()->value('id')
                : null;

            $sale = Sale::create([
                'reference' => $this->generateReference(),
                'customer_id' => $data['customer_id'] ?? null,
                'user_id' => $user?->id,
                'shift_id' => $openShiftId,
                'subtotal' => round($subtotal, 2),
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'discount_amount' => $discountAmount,
                'total' => $total,
                'payment_method' => $method,
                'amount_tendered' => $tendered,
                'change_due' => $changeDue,
                'status' => 'completed',
                'note' => $data['note'] ?? null,
            ]);

            foreach ($lines as $line) {
                $variant = $line['variant'];

                $sale->items()->create([
                    'product_variant_id' => $variant->id,
                    'product_name' => $variant->product?->name ?? '',
                    'variant_name' => $variant->name,
                    'sku' => $variant->sku,
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'cost_price' => $variant->purchase_price,
                    'total' => $line['total'],
                ]);

                if ($variant->product?->track_stock) {
                    $this->stockService->record(
                        $variant,
                        'sale',
                        -$line['quantity'],
                        "Sale {$sale->reference}",
                        'sale',
                        $sale->id
                    );
                }
            }

            return $sale->load('items');
        });
    }

    public function refund(Sale $sale): Sale
    {
        if ($sale->status !== 'completed') {
            abort(422, "Sale {$sale->reference} is already {$sale->status}");
        }

        return DB::transaction(function () use ($sale) {
            $sale->load('items');

            foreach ($sale->items as $item) {
                if (! $item->product_variant_id) continue;

                $variant = ProductVariant::query()->find($item->product_variant_id);
                if (! $variant || ! ($variant->product?->track_stock)) continue;

                $this->stockService->record(
                    $variant,
                    'return',
                    (float) $item->quantity,
                    "Refund {$sale->reference}",
                    'return',
                    $sale->id
                );
            }

            $sale->update([
                'status' => 'refunded',
                'refunded_at' => now(),
            ]);

            return $sale;
        });
    }

    public function stats(): array
    {
        $todayQuery = Sale::query()->where('status', 'completed')->whereDate('created_at', today());

        $todayTotal = (float) (clone $todayQuery)->sum('total');
        $todayCount = (clone $todayQuery)->count();
        $monthTotal = (float) Sale::query()
            ->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $weekSeries = [];
        foreach (range(6, 0) as $i) {
            $day = today()->subDays($i);
            $weekSeries[] = [
                'date' => $day->format('D'),
                'total' => (float) Sale::query()
                    ->where('status', 'completed')
                    ->whereDate('created_at', $day)
                    ->sum('total'),
            ];
        }

        return [
            'today_total' => $todayTotal,
            'today_count' => $todayCount,
            'avg_basket' => $todayCount ? round($todayTotal / $todayCount, 2) : 0.0,
            'month_total' => $monthTotal,
            'week_series' => $weekSeries,
        ];
    }

    private function generateReference(): string
    {
        do {
            $ref = 'INV-' . now()->format('ymd') . '-' . str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        } while (Sale::query()->where('reference', $ref)->exists());

        return $ref;
    }
}
