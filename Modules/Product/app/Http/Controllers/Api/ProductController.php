<?php

namespace Modules\Product\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Product\App\Models\Product;
use Modules\Product\app\Services\ProductService;
use Modules\Product\app\Http\Requests\ProductRequest;

class ProductController extends Controller
{   
    protected $service;    

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }
    public function index()
    {
        $products = $this->service->getAll(true, true, ['status', 'tenant'], 10);
        return success_response('Product List', $products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request) {                
        $product = $this->service
            ->setAttributes($request->all())
            ->productStore();

        return created_responses('Product', $product);
    }
    

    /**
     * Show the specified resource.
     */
    public function show(Product $product)
    {        
        return success_response('Product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product) 
    {        
        $product = $this->service
            ->setModel($product)
            ->setAttrs($request->all())
            ->productUpdate();

        return updated_response('Product', $product);
    }

    /**
     * Remove the specified resource from storage.
    */   
    public function destroy(Product $product) 
    {
        $product->delete();
        return deleted_responses('Product', $product);
    }
}