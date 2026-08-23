<?php

namespace Modules\Product\App\Services;

use App\Services\Core\BaseService;
use App\Services\Core\FileService;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Models\ProductVariant;


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
        array $relations = [],
        int $perPage = 10
    ) {
        //----------------------------------------------
        // List is built from product_variants:
        // every product (single / variant / service)
        // always has at least one variant row
        //----------------------------------------------
        $relations = [
            'product.category',
            'product.brand',
            'product.unit',
            'product.status',
            'attributes',
        ];

        $query = ProductVariant::query()
            ->select('product_variants.*')
            ->join('products', 'products.id', '=', 'product_variants.product_id');

        // Filters (qualified because of the join)
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('product_variants.name', 'like', "%{$search}%")
                  ->orWhere('products.name', 'like', "%{$search}%")
                  ->orWhere('product_variants.sku', 'like', "%{$search}%");
            });
        }

        if (!empty(request('filters.created_at'))) {
            $query->whereDate('product_variants.created_at', request('filters.created_at'));
        }

        if (isset(request('filters')['is_active']) && request('filters.is_active') !== '') {
            $query->where('products.is_active', request('filters.is_active'));
        }

        if (!empty(request('filters.tenant_id'))) {
            $query->where('products.tenant_id', request('filters.tenant_id'));
        }

        // Relations
        if (!empty($relations)) {
            $query->with($relations);
        }

        // Sorting (whitelist, mapped to joined tables)
        if ($isSorted) {
            $sortMap = [
                'name'           => 'product_variants.name',
                'sku'            => 'product_variants.sku',
                'barcode'        => 'product_variants.barcode',
                'purchase_price' => 'product_variants.purchase_price',
                'sale_price'     => 'product_variants.sale_price',
                'stock'          => 'product_variants.stock',
                'thumbnail'      => 'product_variants.thumbnail',
                'created_at'     => 'product_variants.created_at',
                'id'             => 'product_variants.id',
                'product_type'   => 'products.product_type',
                'category_id'    => 'products.category_id',
                'brand_id'       => 'products.brand_id',
                'unit_id'        => 'products.unit_id',
                'is_active'      => 'products.is_active',
            ];

            $column  = request('sort_column', 'id');
            $query->orderBy(
                $sortMap[$column] ?? 'product_variants.id',
                request('sort_direction', 'asc')
            );
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
            'tenant_id'     => $this->resolveTenantId(),
            
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

    private function resolveTenantId()
    {
        return $this->getAttr('tenant_id')
            ?? auth()->user()?->tenant_id;
    }

    private function variantRequests($variant = [])
    {
        return [
            'tenant_id'     => $this->resolveTenantId() ?? 1,
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

            //delete previous thumbnail file
            $this->fileService->delete($this->model->getRawOriginal('thumbnail'));

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

    public function deleteThumbnail()
    {
        $this->fileService->delete($this->model->getRawOriginal('thumbnail'));

        $this->model->update(['thumbnail' => null]);

        return $this;
    }

    public function deleteGallery($mediaId)
    {
        $media = $this->model->media()
            ->where('collection', 'gallery')
            ->findOrFail($mediaId);

        $this->fileService->delete($media->file);

        $media->delete();

        return $this;
    }

    public function storeVariantMedia()
    {
        if ($this->model->product_type === 'variant') {
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
                            'tenant_id'           => $this->resolveTenantId() ?? 1,
                            'attribute_id'        => $attrValue['attribute_id'],
                            'attribute_value_id'  => $attrValue['attribute_value_id'],
                        ]);
                    }
                }
            }

            return $this;
        }

        //----------------------------------------------
        // single & service: always create one default
        // variant from the product-level fields
        //----------------------------------------------
        $data = $this->variantRequests([
            'name'           => $this->getAttr('name'),
            'sku'            => $this->getAttr('sku'),
            'barcode'        => $this->getAttr('barcode'),
            'purchase_price' => $this->getAttr('purchase_price'),
            'sale_price'     => $this->getAttr('sale_price'),
            'stock'          => $this->model->product_type === 'service'
                                    ? 0
                                    : ($this->getAttr('stock') ?? 0),
        ]);

        $this->model->variants()->create($data);

        return $this;
    }

    public function updateVariantMedia()
    {
        //recreate variants on update (simple approach).
        //single & service get their default variant recreated.
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

