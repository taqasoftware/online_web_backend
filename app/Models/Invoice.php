<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceDetails;
use App\Models\User;

    class Invoice extends Model
{
    use HasFactory;
    protected $table = 'tblInvoiceMain';
    protected $fillable = [
        'user_id',
        'InvoiceCustID',
        'InvoiceDate', 
        'InvoiceStatus',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'InvoiceCustID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetails::class);
    }
}
