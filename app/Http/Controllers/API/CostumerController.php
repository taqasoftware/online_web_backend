<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Costumer;
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
        $customers = Costumer::all();
        return $this->sendResponse($customers, "Costumer");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'customers' => 'required|min:1',
            'customers.*.CustName' => 'required',
            'customers.*.CustID' => 'required',
            'customers.*.CustPriceCatID' => 'required',
            'customers.*.CustRegionID' => 'required',
            'customers.*.CustQIDBalance' => 'required|numeric',
            'customers.*.CustUSDBanace' => 'required|numeric',
            'customers.*.CustId' => 'required|int'
        ]; 
        $input = $request->all();
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        for ($x = 0; $x < count($input['customers']); $x++) {
            $costumer_input = $input['customers'][$x];
     
            $costumer = Costumer::firstwhere('CustID',$costumer_input['CustID']);
            if(is_null($costumer)){
                 $costumer = Costumer::create($costumer_input);
            }else{
                $costumer->where('CustId',$costumer_input['CustId'])->update($costumer_input);
            }
          } 
        
       
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
        $customer = Costumer::firstwhere('CustId',$id);

        if (!$customer) {
            return $this->sendError('Costumer does not exist');
        }

        return $this->sendResponse($customer, "Costumer");
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
        
        $customer = Costumer::findwhere('CustId',$id);

        if (!$customer) {
            return $this->sendError('Costumer does not exist');
        }

        $customer->update($validatedData);

        return $this->sendResponse($customer, "Costumer");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Costumer::where('CustID',$id);

        if (!$customer) {
            return $this->sendError('Costumer does not exist');
        }

        $customer->delete();

        return $this->sendResponse($customer, "Costumer");
    }
}