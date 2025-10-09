<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CustomerRepository;
use App\Http\Requests\Customer\CustomerFilterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Requests\Customer\CustomerSearchPOSRequest;
use App\Http\Resources\Customer\CustomersCollection;
use App\Http\Resources\Customer\CustomersResource;
use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{


    public function __construct(public CustomerRepository $customerRepository ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(CustomerFilterRequest $request)
    {

        [$customers, $key] = $this->customerRepository->findAll($request);

        return successResponse($customers, additional: ['pdf_url' => url('reports/customers/' . $key)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate
     * \Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());

        return successResponse(message: "Customer Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return successResponse(new CustomersResource($customer->loadCount('orders')));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return successResponse(message: "Customer Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return successResponse(message: "Customer Deleted Successfully");
    }

    public function searchPOS(CustomerSearchPOSRequest $request)
    {
        $customers = $this->customerRepository->getCustomersForPOS($request);

        return successResponse($customers);
    }
}
