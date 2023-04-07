<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
class CostumerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return $this->sendResponse($costumer, "Costumer");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'custemrs' => 'required|min:1',
            'custemrs*.CustName' => 'required|unique:tblcustemrs*.Customer|max:150',
            'custemrs*.CustPriceCatID' => 'required|exists:tblPriceCat,PriceCatID',
            'custemrs*.CustRegionID' => 'required|exists:tblRegion,RegID',
            'custemrs*.CustQIDBalance' => 'required|numeric',
            'custemrs*.CustUSDBanace' => 'required|numeric',
            'custemrs*.CustId' => 'required|int'
        ]);

        $customer = Customer::create($validatedData);

        return $this->sendResponse($costumer, "Costumer");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findwhere('CustId',$id);

        if (!$customer) {
            return $this->sendError('Costumer does not exist');
        }

        return $this->sendResponse($costumer, "Costumer");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'CustName' => 'required|unique:tblCustomer,CustName,' . $id . ',CustID|max:150',
            'CustPriceCatID' => 'required|exists:tblPriceCat,PriceCatID',
            'CustRegionID' => 'required|exists:tblRegion,RegID',
            'CustQIDBalance' => 'required|numeric',
            'CustUSDBanace' => 'required|numeric'
        ]);

        $customer = Customer::findwhere('CustId',$id);

        if (!$customer) {
            return $this->sendError('Costumer does not exist');
        }

        $customer->update($validatedData);

        return $this->sendResponse($costumer, "Costumer");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::wherefind('CustId',$id);

        if (!$customer) {
            return $this->sendError('Costumer does not exist');
        }

        $customer->delete();

        return $this->sendResponse($costumer, "Costumer");
    }
}