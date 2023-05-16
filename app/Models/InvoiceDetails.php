<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'DetailInvoiceID',
        'DetailProdID',
        'DetailQTY',
        'DetailGIFT',
        'DetailUnitPrice'
    ];
    protected $table = 'tblInvoiceDetail';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'InvCustID');
    }
}
