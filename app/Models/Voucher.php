<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'voucherID',
        'voucherDate',
        'voucherCustomerID',
        'voucherAgentID',
        'voucherAccountUSD',
        'voucherAccountQID',
        'voucherPaidUSD',
        'voucherPaidQID',
        'voucherExchangeRate',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'voucherCustomerID');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'voucherAgentID');
    }
}
