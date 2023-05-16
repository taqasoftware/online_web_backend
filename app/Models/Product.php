<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{ 
    use HasFactory;
    protected $table = 'tblProducts';

    protected $fillable = [
        'ProdName',
        'ProdOrgID',
        'ProdSalePrice1', 
        'ProdSalePrice2',
        'ProdSalePrice3',
        'ProdSalePrice4',
        'ProdGiftBonus',
        'ProdGiftQTY',
        'ProdNote',
        'ProdCurrentBalance'
    ];

    protected $appends = ['quantity'];

    public function origin()
    {
        return $this->belongsTo(Origin::class, 'ProdOrgID');
    }


    public function getquantityAttribute()
{
    return 0;
}


}
