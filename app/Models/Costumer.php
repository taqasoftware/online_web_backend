<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    use HasFactory;
    protected $fillable = [
        'CustID',
        'CustName',
        'CustPriceCatID',
        'CustRegionID',
        'CustQIDBalance',
        'CustUSDBanace'
    ];
    protected $table = 'tblCostumer';

}
