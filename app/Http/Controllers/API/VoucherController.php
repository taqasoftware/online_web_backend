<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\Costumer;
use App\Models\User;
class VoucherController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vouchers = Voucher::all();
        return $this->sendResponse($vouchers, 'Vouchers');
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
            'voucherDate' => 'required|date',
            'voucherCustomerID' => 'required|integer|min:1',
            'voucherAgentID' => 'required|integer|min:1',
            'voucherAccountUSD' => 'required|numeric|min:0',
            'voucherAccountQID' => 'required|numeric|min:0',
            'voucherPaidUSD' => 'required|numeric|min:0',
            'voucherPaidQID' => 'required|numeric|min:0',
            'voucherExchangeRate' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $input =$request->all(); 
        $custumer = Costumer::where('CustID', '=', $input['voucherCustomerID'])->first();
        if (!$custumer) {
            return $this->sendError("costumer not found");
        }
        $agent = User::find($input['voucherAgentID']);
        if (!$agent) {
            return $this->sendError("agent not found");
        }
        $voucher = Voucher::create($request->all());

        return $this->sendResponse($voucher, 'Voucher created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voucher = Voucher::find($id);

        if (is_null($voucher)) {
            return $this->sendError('Voucher does not exist');
        }

        return $this->sendResponse($voucher, 'Voucher');
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
        $voucher = Voucher::find($id);

        if (is_null($voucher)) {
            return $this->sendError('Voucher does not exist');
        }

        $rules = [
            'voucherID' => 'required|max:200',
            'voucherDate' => 'required|date',
            'voucherCustomerID' => 'required|integer|min:1',
            'voucherAgentID' => 'required|integer|min:1',
            'voucherAccountUSD' => 'required|numeric|min:0',
            'voucherAccountQID' => 'required|numeric|min:0',
            'voucherPaidUSD' => 'required|numeric|min:0',
            'voucherPaidQID' => 'required|numeric|min:0',
            'voucherExchangeRate' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $voucher->update($request->all());

        return $this->sendResponse($voucher, 'Voucher updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voucher = Voucher::find($id);

        if (is_null($voucher)) {
            return $this->sendError('Voucher does not exist');
        }

        $voucher->delete();

        return $this->sendResponse([], 'Voucher deleted');
    }
}
