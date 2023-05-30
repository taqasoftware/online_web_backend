<?php

namespace App\Http\Controllers\API;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends BaseController
{
    public function index()
    {

        $vouchers = Voucher::all();

        return $this->sendResponse($vouchers, "vouchers");
    }

    public function show($id)
    {

        $voucher = Voucher::findOrFail($id);

        if (is_null($voucher)) {

            return $this->sendError('voucher does not exist');
        }return $this->sendResponse($voucher, "voucher");
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'code' => 'required|unique:vouchers',
            'amount' => 'required|numeric|min:0',
            'customer_id' => 'required|exists:customers,id',
            'invoice_id' => 'required|exists:invoices,id',
        ]);

        $voucher = Voucher::create($validatedData);

        return $this->sendResponse($voucher, "voucher created");
    }

    public function update(Request $request, $id)
    {

        $voucher = Voucher::findOrFail($id);

        $validatedData = $request->validate([
            'code' => 'required|unique:vouchers,code,',
            'amount' => 'required|numeric|min:0',
        ]);
        $voucher->update($validatedData);

        return $this->sendResponse($voucher, "voucher updated");
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);

        $voucher->delete();

        return $this->sendResponse($voucher, "voucher created");
    }
}
