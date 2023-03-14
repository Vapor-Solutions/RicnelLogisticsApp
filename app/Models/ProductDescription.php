<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDescription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'unit_id',
        'brand_id',
        'title',
        'description',
        'price',
        'product_category_id',
        'quantity'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function productItems()
    {
        return $this->hasMany(ProductItem::class);
    }
    public function getAvailableItemsAttribute()
    {
        $total = 0;

        foreach ($this->productItems as $item) {
            if (!$item->is_sold) {
                $total++;
            }
        }

        return $total;
    }


    public function getTotalValueAttribute()
    {
        return $this->available_items * $this->price;
    }

    public function getActualValueAttribute()
    {
        $total = 0;
        foreach ($this->productItems as $item) {
            if (!$item->is_sold) {
                $total += $item->price;
            }
        }


        return $total;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
