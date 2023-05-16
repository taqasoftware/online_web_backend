<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    use HasFactory;
    protected $fillable = [
        'OrgID',
        'OrgName'
    ];
    protected $table = 'tblOrigin';

    public function products()
    {
        return $this->hasMany(Product::class, 'ProdOrgID');
    }
}
