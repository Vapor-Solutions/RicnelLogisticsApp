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
        'quantity',
        'available_items',
        'avg_price'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productItems()
    {
        return $this->hasMany(ProductItem::class,  'product_description_id', 'id');
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
    public function getAvgPriceAttribute()
    {
        $total = 0;

        foreach ($this->productItems as $item) {
            $total += $item->price;
        }

        return $total / count($this->productItems);
    }
}
