<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_descripton_id',
        'sku_number',
        'price'
    ];


    public function productDescription()
    {
        return $this->belongsTo(ProductDescription::class);
    }

    public function purchases()
    {
        return $this->belongsToMany(Purchase::class, 'purchase_product_item');
    }
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_product_item')->withPivot('sale_price');
    }

    public function getIsSoldAttribute()
    {
        return count($this->sales) > 0;
    }
}
