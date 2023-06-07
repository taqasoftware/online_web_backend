<?php

namespace App\Http\Controllers\API;

use App\Models\InvoiceDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class InvoiceDetailsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {   
        $invoices = InvoiceDetails::join('tblInvoiceMain', 'tblInvoiceDetail.DetailInvoiceID', '=', 'tblInvoiceMain.InvoiceID')
        ->join('tblProducts', 'tblInvoiceDetail.DetailProdID', '=', 'tblProducts.ProdID')
        ->where('tblInvoiceMain.InvoiceID', $id)
        ->select(
            'tblInvoiceMain.InvoiceID as mainInvoiceId',
            'tblProducts.ProdName',
            'tblProducts.ProdID as prodId',
            'tblInvoiceDetail.DetailGIFT as prodGift',
            'tblInvoiceDetail.DetailQTY as prodQit',
            'tblInvoiceDetail.DetailUnitPrice as price'
        )
        ->get();

        return $this->sendResponse($invoices, "Invoice details");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceDetails $invoiceDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceDetails  $invoiceDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceDetails $invoiceDetails)
    {
        //
    }
}
