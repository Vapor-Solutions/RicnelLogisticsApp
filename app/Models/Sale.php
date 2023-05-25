<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    public function productItems()
    {
        return $this->belongsToMany(ProductItem::class, 'sale_product_item')->withPivot('sale_price');
    }

    public function getTotalCostAttribute()
    {
        $total_cost = 0;

        foreach ($this->productItems as $item) {
            $total_cost += $item->pivot->sale_price;
        }


        return $total_cost;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function payments()
    {
        return $this->hasMany(SalesPayment::class);
    }

    public function getBalanceAttribute()
    {
        $balance =  $this->total_cost;

        foreach ($this->payments as $payment) {
            $balance-=$payment->amount;
        }

        return $balance;
    }

    public function productDescriptions()
    {
        return ProductItem::select('product_description_id', DB::raw('COUNT(*) as count'))
            ->groupBy('product_description_id')
            ->whereIn('id', function ($query) {
                $query->select('product_item_id')
                    ->from('sale_product_item')
                    ->where('sale_id', $this->id);
            })
            ->with('productDescription')
            ->get();
    }

}
