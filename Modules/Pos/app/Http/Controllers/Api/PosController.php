<?php

namespace Modules\Pos\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\App\Models\ProductVariant;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $variants = ProductVariant::query()
            ->with([
                'product:id,name,thumbnail,track_stock,alert_quantity,category_id,unit_id,product_type',
                'product.category:id,name',
                'product.unit:id,name',
            ])
            ->whereHas('product', function ($q) {
                $q->where('is_active', true);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%' . $request->input('search') . '%';
                $q->where(function ($qq) use ($term) {
                    $qq->where('product_variants.name', 'like', $term)
                        ->orWhere('product_variants.sku', 'like', $term)
                        ->orWhere('product_variants.barcode', 'like', $term)
                        ->orWhereHas('product', function ($p) use ($term) {
                            $p->where('name', 'like', $term);
                        });
                });
            })
            ->when($request->filled('category_id'), function ($q) use ($request) {
                $q->whereHas('product', function ($p) use ($request) {
                    $p->where('category_id', $request->input('category_id'));
                });
            })
            ->orderBy('product_variants.name')
            ->limit(300)
            ->get();

        return success_response('POS Products', $variants);
    }
}
