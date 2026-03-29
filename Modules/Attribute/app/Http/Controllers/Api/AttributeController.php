<?php
namespace Modules\Attribute\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Attribute\app\Http\Requests\AttributeRequest;
use Modules\Attribute\app\Models\Attribute;
use Modules\Attribute\app\Services\AttributeService;

class AttributeController extends Controller
{   
    protected $service;    

    public function __construct(AttributeService $attributeService)
    {
        $this->service = $attributeService;
    }
    public function index()
    {
        $units = $this->service->getAll(true, true, ['status', 'tenant'], 10);
        return success_response('Attribute List', $units);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeRequest $request) {                
        $attribute = $this->service
            ->setAttributes($request->all())
            ->store();

        return created_responses('Attribute', $attribute);
    }
    

    /**
     * Show the specified resource.
     */
    public function show(Attribute $attribute)
    {        
        // $attribute = $this->service->findAttributeById($id);
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
            ->update();

        return updated_response('Attribute', $attribute);
    }

    /**
     * Remove the specified resource from storage.
    */   
    public function destroy(Attribute $attribute) 
    {
        $attribute->delete();
        return deleted_responses('Attribute', $attribute);
    }
}