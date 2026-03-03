<?php

// namespace App\Http\Controllers;

// abstract class Controller
// {
//     //
// }



namespace App\Http\Controllers;

use App\Helpers\Traits\HasAttrs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use HasAttrs, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $service;
    protected $name = 'something';
}

