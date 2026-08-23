<?php

namespace Modules\Register\App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Register\App\Models\RegisterCashMovement;
use Modules\Register\App\Models\RegisterShift;
use Modules\Sales\App\Models\Sale;

class RegisterService
{
    public function currentShift(): ?RegisterShift
    {
        return RegisterShift::query()->open()->with('cashier:id,name')->first();
    }

    public function open(array $data): RegisterShift
    {
        if ($this->currentShift()) {
            abort(422, 'A register shift is already open. Close it first.');
        }

        /** @var User|null $user */
        $user = auth()->user();

        return RegisterShift::create([
            'register_name' => $data['register_name'] ?? 'Main Register',
            'opening_float' => max(0, (float) ($data['opening_float'] ?? 0)),
            'status' => 'open',
            'opened_at' => now(),
            'user_id' => $user?->id,
        ]);
    }

    public function close(RegisterShift $shift, array $data): RegisterShift
    {
        if ($shift->status !== 'open') {
            abort(422, 'This shift is already closed');
        }

        return DB::transaction(function () use ($shift, $data) {
            $stats = $this->liveStats($shift);

            $counted = max(0, (float) $data['closing_counted']);

            $shift->update([
                'status' => 'closed',
                'closing_counted' => $counted,
                'expected_cash' => $stats['expected_cash'],
                'difference' => round($counted - $stats['expected_cash'], 2),
                'closed_at' => now(),
                'note' => $data['note'] ?? null,
            ]);

            return $shift->fresh(['cashier:id,name']);
        });
    }

    public function liveStats(RegisterShift $shift): array
    {
        $sales = Sale::query()
            ->where('shift_id', $shift->id)
            ->selectRaw("payment_method, status, COUNT(*) as cnt, COALESCE(SUM(total),0) as total")
            ->groupBy('payment_method', 'status')
            ->get();

        $sumBy = fn ($method, $status = 'completed') => (float) $sales
            ->where('payment_method', $method)
            ->where('status', $status)
            ->sum('total');

        $countBy = fn ($method, $status = 'completed') => (int) $sales
            ->where('payment_method', $method)
            ->where('status', $status)
            ->sum('cnt');

        $cashIn = (float) RegisterCashMovement::query()
            ->where('shift_id', $shift->id)->where('type', 'cash_in')->sum('amount');
        $cashOut = (float) RegisterCashMovement::query()
            ->where('shift_id', $shift->id)->where('type', 'cash_out')->sum('amount');

        $cashSales = $sumBy('cash');
        $cashRefunds = abs($sumBy('cash', 'refunded'));

        $expectedCash = round(
            (float) $shift->opening_float + $cashSales - $cashRefunds + $cashIn - $cashOut,
            2
        );

        return [
            'expected_cash' => $expectedCash,
            'cash_sales' => $cashSales,
            'cash_refunds' => $cashRefunds,
            'cash_count' => $countBy('cash'),
            'card_total' => $sumBy('card'),
            'card_count' => $countBy('card'),
            'mobile_total' => $sumBy('mobile'),
            'mobile_count' => $countBy('mobile'),
            'total_revenue' => round($sumBy('cash') + $sumBy('card') + $sumBy('mobile'), 2),
            'transactions' => $countBy('cash') + $countBy('card') + $countBy('mobile'),
        ];
    }

    public function addMovement(RegisterShift $shift, string $type, float $amount, ?string $reason = null): RegisterCashMovement
    {
        if ($shift->status !== 'open') {
            abort(422, 'Cannot add cash movements to a closed shift');
        }

        return RegisterCashMovement::create([
            'shift_id' => $shift->id,
            'type' => in_array($type, ['cash_in', 'cash_out']) ? $type : 'cash_in',
            'amount' => max(0.01, $amount),
            'reason' => $reason,
            'user_id' => auth()->id(),
        ]);
    }

    public function history()
    {
        return RegisterShift::query()
            ->with(['cashier:id,name'])
            ->withCount('movements')
            ->when(request('search'), function ($q, $term) {
                $q->where(function ($qq) use ($term) {
                    $qq->where('register_name', 'like', "%{$term}%")
                        ->orWhereHas('cashier', fn ($c) => $c->where('name', 'like', "%{$term}%"));
                });
            })
            ->orderByDesc('id')
            ->paginate(request('per_page', 10))
            ->withQueryString();
    }
}
