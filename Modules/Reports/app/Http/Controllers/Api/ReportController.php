<?php

namespace Modules\Reports\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Modules\Reports\App\Services\ReportService;

class ReportController extends Controller
{
    protected $service;

    public function __construct(ReportService $service)
    {
        $this->service = $service;
    }

    public function overview()
    {
        return success_response('Report overview generated successfully', $this->service->overview());
    }
}
