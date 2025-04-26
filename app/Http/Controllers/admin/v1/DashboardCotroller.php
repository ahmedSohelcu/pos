<?php

namespace App\Http\Controllers\admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCotroller extends Controller
{
    public function dashboard()
    {
        return view('admin.v1.layouts.master');
    }
}
