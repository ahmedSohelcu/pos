<?php

namespace Modules\Product\App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends BaseRequest
{
   
    public function rules(): array
    {
        $product_id = $this->route('product')?->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($product_id),
            ],
            'slug' => [
                'nullable',
                Rule::unique('products', 'slug')->ignore($product_id),
            ],
            'product_type'      => ['required', Rule::in(['single', 'variant', 'service'])],            
            'tenant_id'         => ['nullable','exists:tenants,id'],
            'category_id'       => ['nullable','exists:categories,id'],
            'brand_id'          => ['nullable','exists:brands,id'],
            'unit_id'           => ['nullable','exists:units,id'],
            'sku'               => ['nullable','string'],
            
            'purchase_price'    => ['nullable','numeric'],
            'sale_price'        => ['nullable','numeric'],

            'product_thumbnail' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:1024'],                      

            'product_galleries' => 'nullable|array',
            'product_galleries.*' => 'file|image|mimes:jpg,jpeg,png,webp|max:2048',

            'barcode'       => ['nullable','string'],
            'stock'         => ['nullable','integer'],
            'alert_quantity'=> ['nullable','integer'],
            'track_stock'   => ['nullable','boolean'],
            'sorting_order' => ['nullable','integer'],
            'description' => ['nullable'],
            // 'is_active' => ['nullable', 'boolean'],
            

            //---------------------------------
            // Variants
            //---------------------------------
            'variants' => ['nullable', 'array'],
            'variants.*.name' => ['nullable', 'string'],
            'variants.*.sku' => ['nullable', 'string'],
            'variants.*.barcode' => ['nullable', 'string'],
            'variants.*.purchase_price' => ['nullable', 'numeric'],
            'variants.*.sale_price' => ['nullable', 'numeric'],
            'variants.*.stock' => ['nullable', 'integer'],
            'variants.*.attributes' => ['nullable', 'array'],
            'variants.*.attributes.*.attribute_id' => ['required', 'exists:attributes,id'],
            'variants.*.attributes.*.attribute_value_id' => ['required', 'exists:attribute_values,id'],
            'variants.*.variant_thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ];
    }
}