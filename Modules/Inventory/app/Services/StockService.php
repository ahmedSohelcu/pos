<?php

namespace Modules\Inventory\App\Services;

use Illuminate\Support\Facades\DB;
use Modules\Inventory\App\Models\StockMovement;
use Modules\Product\App\Models\ProductVariant;

class StockService
{
    /**
     * Apply a signed stock delta to a variant and record the movement.
     * Must be called inside a transaction (or locks its own).
     */
    public function record(
        ProductVariant $variant,
        string $type,
        float $delta,
        ?string $note = null,
        ?string $referenceType = null,
        ?int $referenceId = null
    ): StockMovement {
        return DB::transaction(function () use ($variant, $type, $delta, $note, $referenceType, $referenceId) {
            $locked = ProductVariant::query()->lockForUpdate()->findOrFail($variant->id);

            $before = (float) $locked->stock;
            $after = round($before + $delta, 2);

            if ($after < 0) {
                throw new \InvalidArgumentException("Insufficient stock for {$locked->name} ({$before} available)");
            }

            $locked->update(['stock' => $after]);

            return StockMovement::create([
                'product_variant_id' => $locked->id,
                'type' => $type,
                'quantity' => round($delta, 2),
                'stock_before' => $before,
                'stock_after' => $after,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'note' => $note,
            ]);
        });
    }

    public function adjust(int $variantId, string $mode, float $value, ?string $note = null): StockMovement
    {
        return DB::transaction(function () use ($variantId, $mode, $value, $note) {
            $variant = ProductVariant::query()->lockForUpdate()->findOrFail($variantId);

            $current = (float) $variant->stock;
            $delta = $mode === 'set' ? round($value - $current, 2) : round($value, 2);

            return $this->record($variant, 'adjustment', $delta, $note ?: 'Manual stock adjustment');
        });
    }

    public function movementsQuery()
    {
        return StockMovement::query()
            ->with(['variant.product:id,name,thumbnail', 'variant:id,product_id,name,sku,stock'])
            ->when(request('search'), function ($q) {
                $term = '%' . request('search') . '%';
                $q->where(function ($qq) use ($term) {
                    $qq->where('note', 'like', $term)
                        ->orWhereHas('variant', fn ($v) => $v->where(function ($w) use ($term) {
                            $w->where('name', 'like', $term)
                                ->orWhere('sku', 'like', $term)
                                ->orWhere('barcode', 'like', $term)
                                ->orWhereHas('product', fn ($p) => $p->where('name', 'like', $term));
                        }));
                });
            })
            ->when(request('type'), fn ($q) => $q->where('type', request('type')))
            ->orderByDesc('id');
    }

    public function lowStock(int $limit = 50)
    {
        return ProductVariant::query()
            ->with(['product:id,name,thumbnail,track_stock,alert_quantity,unit_id', 'product.unit:id,name'])
            ->whereHas('product', fn ($p) => $p->where('track_stock', true)->where('is_active', true))
            ->whereColumn('product_variants.stock', '<=', 'products.alert_quantity')
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->orderBy('product_variants.stock')
            ->limit($limit)
            ->get(['product_variants.*']);
    }

    public function stats(): array
    {
        $tracked = ProductVariant::query()
            ->whereHas('product', fn ($p) => $p->where('track_stock', true)->where('is_active', true))
            ->selectRaw("
                COUNT(*) as tracked_skus,
                SUM(CASE WHEN product_variants.stock <= 0 THEN 1 ELSE 0 END) as out_of_stock,
                SUM(CASE WHEN product_variants.stock > 0 AND product_variants.stock <= products.alert_quantity THEN 1 ELSE 0 END) as low_stock
            ")
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->first();

        $movementsToday = StockMovement::query()->whereDate('created_at', today())->count();

        return [
            'tracked_skus' => (int) ($tracked->tracked_skus ?? 0),
            'low_stock' => (int) ($tracked->low_stock ?? 0),
            'out_of_stock' => (int) ($tracked->out_of_stock ?? 0),
            'movements_today' => $movementsToday,
        ];
    }
}
