<?php

namespace Modules\Reports\App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Modules\Sales\App\Models\Sale;
use Modules\Sales\App\Models\SaleItem;

class ReportService
{
    private CarbonImmutable $from;
    private CarbonImmutable $to;

    private function range(): void
    {
        $this->from = CarbonImmutable::parse(request('date_from', today()->subDays(6)));
        $this->to = CarbonImmutable::parse(request('date_to', today()));
    }

    private function saleQuery()
    {
        $this->range();

        return Sale::query()
            ->where('status', 'completed')
            ->whereBetween('created_at', [$this->from->startOfDay(), $this->to->endOfDay()]);
    }

    private function itemQuery()
    {
        $this->range();

        return SaleItem::query()
            ->whereHas('sale', function ($q) {
                $q->where('status', 'completed')
                    ->whereBetween('created_at', [$this->from->startOfDay(), $this->to->endOfDay()]);
            });
    }

    public function overview(): array
    {
        $base = $this->saleQuery();

        $totals = (clone $base)->selectRaw("
                COALESCE(SUM(total),0) as revenue,
                COUNT(*) as transactions,
                COALESCE(SUM(discount_amount),0) as discounts,
                COALESCE(AVG(total),0) as avg_basket
            ")->first();

        $itemTotals = $this->itemQuery()->selectRaw("
                COALESCE(SUM(quantity),0) as items_sold,
                COALESCE(SUM(sale_items.total - COALESCE(sale_items.cost_price,0) * sale_items.quantity),0) as profit
            ")->first();

        $revenue = (float) $totals->revenue;
        $profit = (float) $itemTotals->profit;
        $transactions = (int) $totals->transactions;

        return [
            'kpis' => [
                'revenue' => round($revenue, 2),
                'profit' => round($profit, 2),
                'margin_pct' => $revenue > 0 ? round($profit / $revenue * 100, 1) : 0,
                'transactions' => $transactions,
                'items_sold' => round((float) $itemTotals->items_sold, 2),
                'avg_basket' => round((float) $totals->avg_basket, 2),
                'discounts' => round((float) $totals->discounts, 2),
            ],
            'daily_series' => $this->dailySeries(),
            'top_products' => $this->topProducts(),
            'by_cashier' => $this->byCashier(),
            'by_category' => $this->byCategory(),
            'range' => [
                'from' => $this->from->toDateString(),
                'to' => $this->to->toDateString(),
            ],
        ];
    }

    private function dailySeries(): array
    {
        $revenueByDay = (clone $this->saleQuery())
            ->selectRaw("DATE(created_at) as d, SUM(total) as revenue")
            ->groupBy('d')
            ->pluck('revenue', 'd');

        $profitByDay = (clone $this->itemQuery())
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->selectRaw("DATE(sales.created_at) as d, SUM(sale_items.total - COALESCE(sale_items.cost_price,0) * sale_items.quantity) as profit")
            ->groupBy('d')
            ->pluck('profit', 'd');

        $series = [];
        foreach (CarbonImmutable::parse($this->from)->toPeriod($this->to, '1 day') as $day) {
            $key = $day->toDateString();
            $series[] = [
                'date' => $day->format('M j'),
                'revenue' => round((float) ($revenueByDay[$key] ?? 0), 2),
                'profit' => round((float) ($profitByDay[$key] ?? 0), 2),
            ];
        }

        return $series;
    }

    private function topProducts(int $limit = 8): array
    {
        return $this->itemQuery()
            ->selectRaw("
                sale_items.product_variant_id,
                TRIM(BOTH ' · ' FROM CONCAT_WS(' · ', NULLIF(MAX(sale_items.product_name),''), NULLIF(MAX(sale_items.variant_name),''))) as label,
                SUM(sale_items.quantity) as qty,
                SUM(sale_items.total) as revenue
            ")
            ->groupBy('sale_items.product_variant_id')
            ->orderByDesc('revenue')
            ->limit($limit)
            ->get()
            ->map(fn ($row) => [
                'label' => $row->label ?: 'Unknown product',
                'qty' => round((float) $row->qty, 2),
                'revenue' => round((float) $row->revenue, 2),
            ])
            ->all();
    }

    private function byCashier(): array
    {
        return Sale::query()
            ->where('status', 'completed')
            ->whereBetween('sales.created_at', [$this->from->startOfDay(), $this->to->endOfDay()])
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->selectRaw("users.name as cashier, COUNT(*) as transactions, COALESCE(SUM(sales.total),0) as revenue, COALESCE(AVG(sales.total),0) as avg_basket")
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('revenue')
            ->get()
            ->map(fn ($row) => [
                'cashier' => $row->cashier,
                'transactions' => (int) $row->transactions,
                'revenue' => round((float) $row->revenue, 2),
                'avg_basket' => round((float) $row->avg_basket, 2),
            ])
            ->all();
    }

    private function byCategory(): array
    {
        return $this->itemQuery()
            ->join('product_variants', 'product_variants.id', '=', 'sale_items.product_variant_id')
            ->join('products', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->selectRaw("COALESCE(categories.name, 'Uncategorized') as category, SUM(sale_items.total) as revenue")
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->limit(8)
            ->get()
            ->map(fn ($row) => [
                'category' => $row->category,
                'revenue' => round((float) $row->revenue, 2),
            ])
            ->all();
    }
}
