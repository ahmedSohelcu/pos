<?php

namespace Modules\Product\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Core\FileService;
use Illuminate\Support\Facades\DB;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Services\ProductService;
use Modules\Product\app\Http\Requests\ProductRequest;

class ProductController extends Controller
{   
    protected $fileService;

    public function __construct(
            ProductService $productService,
            FileService $fileService
        )
    {
        $this->service = $productService;
        $this->fileService = $fileService;

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
        $product = DB::transaction(function () use ($request) {
            return $this->service
                ->setAttributes($request->all())
                ->storeProductInfo()
                ->storeProductMedia()
                ->storeVariantMedia()
                ->getModel()
                ->load(["variants.attributes", "media"]);
        });

        return created_responses('Product', $product);
    }
    

    /**
     * Show the specified resource.
     */
    public function show(Product $product)
    {        
        $product->load(["variants.attributes", "media"]);

        return success_response('Product', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product) 
    {        
        $product = DB::transaction(function () use ($request, $product) {
            return $this->service
                ->setModel($product)
                ->setAttrs($request->all())
                ->productUpdate()
                ->updateProductMedia()
                ->updateVariantMedia()
                ->getModel()
                ->load(["variants.attributes", "media"]);
        });

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