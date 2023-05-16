<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable = [
        'RegId',
        'RegName'
    ];
    protected $table = 'tblRegion';

    public function customers()
    {
        return $this->hasMany(Customer::class, 'CustRegionID');
    }
}
