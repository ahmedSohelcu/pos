<?php
namespace Modules\Attribute\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Attribute\app\Http\Requests\AttributeRequest;
use Modules\Attribute\app\Models\Attribute;
use Modules\Attribute\app\Services\AttributeService;
use Modules\Product\app\Models\VariantAttributeValue;

class AttributeController extends Controller
{   
    protected $service;    

    public function __construct(AttributeService $attributeService)
    {
        $this->service = $attributeService;
    }
    public function index()
    {
        $attributes = $this->service->getAll(true, true, ['status', 'tenant', 'values'], 10);
        return success_response('Attribute List', $attributes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeRequest $request) 
    {
        DB::transaction(function () use ($request) {           
            $attribute = $this->service
                ->setAttributes($request->all())
                ->storeAttributeData()
                ->storeAttributeValues();

            return created_responses('Attribute', $attribute);
        });
    }
    

    /**
     * Show the specified resource.
     */
    public function show(Attribute $attribute)
    {        
        $attribute = $attribute->load('values:id,attribute_id,tenant_id,slug,value');
        return success_response('Attribute', $attribute);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeRequest $request, Attribute $attribute) 
    {        
        $attribute = $this->service
            ->setModel($attribute)
            ->setAttrs($request->all())
            ->updateAttributeData()
            ->updateAttributeValues();

        return updated_response('Attribute', $attribute);
    }

    /**
     * Remove the specified resource from storage.
    */   
    public function destroy(Attribute $attribute) 
    {
        if (VariantAttributeValue::where('attribute_id', $attribute->id)->exists()) {
            return failed_response("Attribute is used in Variant's product", [], 422);
        }    
        $attribute->values()->delete();
        return deleted_responses('Attribute', $attribute);
    }
}