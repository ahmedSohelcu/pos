<?php

namespace Modules\Inventory\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\App\Services\StockService;

class InventoryController extends Controller
{
    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function movements(Request $request)
    {
        return success_response('Stock Movements', $this->stockService->movementsQuery()->paginate($request->integer('per_page', 10))->withQueryString());
    }

    public function lowStock()
    {
        return success_response('Low Stock Products', $this->stockService->lowStock());
    }

    public function stats()
    {
        return success_response('Inventory Stats', $this->stockService->stats());
    }

    public function adjust(Request $request)
    {
        $validated = $request->validate([
            'product_variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'mode' => ['required', 'in:set,add'],
            'value' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $movement = DB::transaction(
            fn () => $this->stockService->adjust(
                $validated['product_variant_id'],
                $validated['mode'],
                (float) $validated['value'],
                $validated['note'] ?? null
            )
        );

        return created_responses('Stock adjusted', $movement->load('variant.product:id,name'));
    }
}
