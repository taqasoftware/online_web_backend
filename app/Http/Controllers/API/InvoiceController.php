<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Costumer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::select('tblInvoiceMain.InvoiceID as MainID', 'tblInvoiceMain.user_id as userd', 'tblInvoiceMain.InvoiceCustID as CustID', 'tblInvoiceMain.InvoiceDate as Date', 'users.name', 'tblCustomer.CustName')
            ->join('users', 'tblInvoiceMain.user_id', '=', 'users.userId')
            ->join('tblCustomer', 'tblInvoiceMain.InvoiceCustID', '=', 'tblCustomer.CustID')
            ->where('tblInvoiceMain.InvoiceStatus', 1)
            ->get();

        return $this->sendResponse($invoices, "Invoices");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = [
            'agent_id' => 'required',
            'products' => 'required|array',
            'products.*.ProdID' => 'required|numeric',
            'products.*.quantity' => 'required|numeric',
            'products.*.ProdGiftBonus' => 'required|numeric',
            'products.*.DetailUnitPrice' => 'required|numeric',
            'InvoiceCustId' => 'required',
        ];
        $input = $request->all();
        $validator = Validator::make($input, $roles);
        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }
        $custumer = Costumer::where('CustID', '=', $input['InvoiceCustId'])->first();
        if (!$custumer) {
            return $this->sendError("costumer not found");
        }
        $newInvoiceInput = [
            'user_id' => $input['agent_id'],
            'InvoiceCustID' => $custumer->CustID,
            'InvoiceDate' => $currentDate = Carbon::now(),
            'InvoiceStatus' => 1,

        ];
        $newInvoice = Invoice::create($newInvoiceInput);

        $input = $request->all();
        $detailsInput = $input['products'];
        $details = [];
        foreach ($detailsInput as $value) {
            $invoiceDetailsInput = [
                'DetailInvoiceID' => $newInvoice->id,
                'DetailProdID' => $value['ProdID'],
                'DetailQTY' => $value['quantity'],
                'DetailGIFT' => $value['ProdGiftBonus'],
                'DetailUnitPrice' => $value['DetailUnitPrice'],
            ];

            $detail = InvoiceDetails::create($invoiceDetailsInput);
            array_push($details, $detail);
        }

        return $this->sendResponse($newInvoice, "Invoice created");
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');

        // Find the invoice by ID
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return $this->sendError("invoice not found");
        }

        // Update the status
        $invoice->InvoiceStatus = $status;
        $invoice->save();

        return $this->sendResponse($invoice, "Invoice status updated");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
