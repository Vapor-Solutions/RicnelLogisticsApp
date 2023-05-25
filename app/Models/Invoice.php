<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory;



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function productItems()
    {
        return $this->sale->productItems;
    }


    public function productDescriptions()
    {
        return ProductItem::select('product_description_id', DB::raw('MAX(product_items.id) as id'), DB::raw('COUNT(*) as count'))
            ->groupBy('product_description_id')
            ->whereIn('id', function ($query) {
                $query->select('product_item_id')
                    ->from('sale_product_item')
                    ->where('sale_id', $this->sale_id);
            })
            ->with('productDescription')
            ->get();
    }
}
