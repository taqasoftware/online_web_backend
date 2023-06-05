<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Costumer extends Model
    {
        use HasFactory;
        protected $table = 'tblCustomer';
    

        protected $fillable = [
           "CustID", 'CustName', 'CustPriceCatID', 'CustRegionID', 'CustQIDBalance', 'CustUSDBanace'
        ];

        public function priceCategory()
        {
            return $this->belongsTo(PriceCategory::class, 'CustPriceCatID');
        }

        public function region()
        {
            return $this->belongsTo(Region::class, 'CustRegionID');
        }
    }
