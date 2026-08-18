<?php

namespace Modules\Product\App\Services;

use App\Services\Core\BaseService;
use App\Services\Core\FileService;
use Modules\Product\app\Models\Product;


class ProductService extends BaseService
{
    protected $fileService;
    protected $product_thumbnail_directory = 'products/thumbnails';
    protected $product_galleries_directory = 'products/galleries';

    public function __construct(Product $product, FileService $fileService)
    {
        $this->model = $product;
        $this->fileService = $fileService;
    }

    public function getAll(
        bool $isPaginated = true,
        bool $isSorted = true,
        array $relations = ['status', 'tenant', 'category', 'brand', 'unit'],
        int $perPage = 10
    ) {
        $query = $this->model
            ->filters(request()->filters ?? []);

        // Relations
        if (!empty($relations)) {
            $query->with($relations);
        }

        // Sorting
        if ($isSorted) {
            $query->sort();
        }

        // Pagination or Get
        if ($isPaginated) {
            return $query
                ->paginate(request('per_page', $perPage))
                ->withQueryString();
        }

        return $query->get();
    }

    public function storeProductInfo()
    {
        $this->model = $this->model->create($this->productRequests());        
        return $this;
    }

    public function productUpdate()
    {
        $this->model->update($this->productRequests());
        return $this;
    }

    private function productRequests(){
        return [
            'name'          => $this->getAttr('name') ?? null,
            'product_type'  => $this->getAttr('product_type') ?? null,
            'tenant_id'     => $this->getAttr('tenant_id') ?? null, //should be auto filled
            
            'sku'           => $this->getAttr('sku') ?? null,
            'barcode'       => $this->getAttr('barcode') ?? null,
            'purchase_price'=> $this->getAttr('purchase_price') ?? null,
            'sale_price'    => $this->getAttr('sale_price') ?? null,
            'track_stock'   => $this->getAttr('track_stock') ?? null,
            'stock'         => $this->getAttr('stock') ?? null,
            'alert_quantity'=> $this->getAttr('alert_quantity') ?? null,

            'is_active'     => $this->getAttr('is_active') ?? null,
            // 'status_id'     => $this->getAttr('status_id') ?? null,
            'category_id'   => $this->getAttr('category_id') ?? null,
            'brand_id'      => $this->getAttr('brand_id') ?? null,
            'unit_id'       => $this->getAttr('unit_id') ?? null,            
            'description'   => $this->getAttr('description') ?? null,
            'sorting_order' => $this->getAttr('sorting_order') ?? null,
        ];
    }

    private function variantRequests($variant = [])
    {        
        return [
            'tenant_id'     => $this->getAttr('tenant_id') ?? null,
            'name'          => $variant['name'] ?? null,
            'sku'           => $variant['sku'] ?? null,
            'barcode'       => $variant['barcode'] ?? null,
            'purchase_price'=> $variant['purchase_price'] ?? 0,
            'sale_price'    => $variant['sale_price'] ?? 0,
            'stock'         => $variant['stock'] ?? 0,
            'thumbnail'     => $variant['variant_thumbnail'] ?? null
        ];
    }



    public function storeProductMedia()
    {
        //------------------------
        //product_thumbnail
        //------------------------
        if ($product_thumbnail = $this->getAttr('product_thumbnail')) {             
            $path = $this->fileService->upload(
                $product_thumbnail,
                $this->product_thumbnail_directory
            );

             //update product thumbnail
            $this->model->update([
                'thumbnail' => $path
            ]);
        }
        
         /*
        |--------------------------------------------------------------------------
        | GALLERIES
        |--------------------------------------------------------------------------
        */

        if ($galleries = $this->getAttr('product_galleries')) {

            foreach ($galleries as $index => $file) {

                $this->fileService->storeMedia(
                    $this->model,
                    $file,
                    $this->product_galleries_directory,
                    'gallery',
                    $index + 1
                );
            }
        }

        return $this;
    }     

    public function updateProductMedia()
    {
        return $this->storeProductMedia();
    }     

    public function storeVariantMedia()
    {
        if ($this->model->product_type !== 'variant') {
            return $this;
        }

        $variants = $this->getAttr('variants') ?? [];

        foreach ($variants as $variant) {

            $data = $this->variantRequests($variant);

            //upload variant thumbnail
            if (!empty($variant['variant_thumbnail'])) {
                $data['thumbnail'] = $this->fileService->upload(
                    $variant['variant_thumbnail'],
                    $this->product_thumbnail_directory
                );
            }

            $createdVariant = $this->model->variants()->create($data);

            //store variant attribute values
            if (!empty($variant['attributes'])) {
                foreach ($variant['attributes'] as $attrValue) {
                    $createdVariant->attributeValues()->create([
                        'tenant_id'           => $this->getAttr('tenant_id') ?? null,
                        'attribute_id'        => $attrValue['attribute_id'],
                        'attribute_value_id'  => $attrValue['attribute_value_id'],
                    ]);
                }
            }
        }

        return $this;
    }     

    public function updateVariantMedia()
    {
        if ($this->model->product_type !== 'variant') {
            $this->model->variants()->delete();
            return $this;
        }

        //recreate variants on update (simple approach)
        $this->model->variants()->delete();
        $this->storeVariantMedia();

        return $this;
    }



    public function generateCombinations($arrays)
    {
        $result = [[]];

        foreach ($arrays as $property => $values) {
            $tmp = [];

            foreach ($result as $resultItem) {
                foreach ($values as $value) {
                    $tmp[] = array_merge($resultItem, [$property => $value]);
                }
            }

            $result = $tmp;
        }

        return $result;

        // $variants = generateCombinations([
        //     'size' => ['S','M','L'],
        //     'color' => ['Red','Blue']
        // ]);

        // dd($variants);

    }

}

