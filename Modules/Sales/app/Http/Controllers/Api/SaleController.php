<?php

namespace Modules\Sales\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Sales\App\Http\Requests\StoreSaleRequest;
use Modules\Sales\App\Models\Sale;
use Modules\Sales\App\Services\SaleService;

class SaleController extends Controller
{
    public function __construct(SaleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return success_response('Sales List', $this->service->getAll());
    }

    public function store(StoreSaleRequest $request)
    {
        $sale = $this->service->create($request->validated());

        return created_responses('Sale completed successfully', $sale->load('items'));
    }

    public function show(Sale $sale)
    {
        return success_response('Sale', $sale->load(['items', 'customer:id,name', 'cashier:id,name']));
    }

    public function refund(Sale $sale)
    {
        $sale = $this->service->refund($sale);

        return success_response("Sale {$sale->reference} refunded", $sale);
    }

    public function stats()
    {
        return success_response('Sales Stats', $this->service->stats());
    }
}
