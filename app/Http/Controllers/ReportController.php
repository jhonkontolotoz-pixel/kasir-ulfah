<?php

namespace App\Http\Controllers;

use App\Http\Services\PDFService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function categoriesReport(Request $request , $key){

        $data = Cache::get($key);
        $pdf = (new PDFService)->prepare("reports.categories",['categories' => $data->resolve() , 'date' => Carbon::now()->format('Y-m-d h:i a')] , now().'_'.'Categories-Report.pdf', preview: $request->preview ?? false);
        return $pdf;
    }

    public function productsReport(Request $request , $key){

        $data = Cache::get($key);
        $pdf = (new PDFService)->prepare("reports.products",['products' => $data->resolve() , 'date' => Carbon::now()->format('Y-m-d h:i a')] , now().'-'.'Products-Report.pdf' , preview: $request->preview ?? false);
        return $pdf;
    }
    
    public function ordersReport(Request $request , $key){

        $data = Cache::get($key);
        $pdf = (new PDFService)->prepare("reports.orders",['orders' => $data->resolve() , 'date' => Carbon::now()->format('Y-m-d h:i a')] , now().'-'.'Orders-Report.pdf' ,preview: $request->preview ?? false);
        return $pdf;
    }
    
    public function customersReport(Request $request , $key){

        $data = Cache::get($key);
        $pdf = (new PDFService)->prepare("reports.customers",['customers' => $data->resolve(), 'date' => Carbon::now()->format('Y-m-d h:i a')] , now().'-'.'Customers-Report.pdf', preview:$request->preview ?? false);
        return $pdf;
    }
    
    public function receipt(Request $request , $key){

        $data = Cache::get($key);
        $pdf = (new PDFService)->prepare("reports.receipt",['receipt' => $data, 'date' => Carbon::now()->format('Y-m-d h:i a')] , now().'-'.'Receipt.pdf' , preview:$request->preview ?? false);
        return $pdf;
    }
    
}
