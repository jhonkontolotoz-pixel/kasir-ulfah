<?php

namespace App\Http\Controllers;

use App\Http\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        return simpleSuccessResponse(DashboardService::counts($request));
    }


}