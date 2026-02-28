<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Core\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Tenant\app\Models\Tenant;

class StatusController extends Controller
{
    
    /**
     * Get all selectable statuses.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectableStatuses($type = null)
    {
        return Status::query()
            ->where('type', $type)
            ->select('id', 'name')
            ->get();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
