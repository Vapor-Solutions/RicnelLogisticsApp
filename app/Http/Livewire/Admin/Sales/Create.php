<?php

namespace App\Http\Livewire\Admin\Sales;

use App\Models\ProductDescription;
use App\Models\ProductItem;
use App\Models\Sale;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Create extends Component
{
    public $productDescriptions;

    public $productsList = [];
    public Sale $sale;

    protected $rules = [
        'sale.sale_date' => 'required',
        'sale.customer_id' => 'required',
    ];

    public $product_id, $quantity, $price;


    public function mount()
    {
        $this->productDescriptions = ProductDescription::all();
        $this->sale =  new Sale();
    }

    public function addToCart()
    {
        $this->validate([
            'product_id' => 'required',
            'quantity' => 'required|min:1',
            'price' => 'required',
        ]);

        $count = 0;
        if (count($this->productsList) > 0) {

            for ($i = 0; $i < count($this->productsList); $i++) {
                if (intval($this->productsList[$i][0]) == intval($this->product_id)) {
                    if ($this->price != intval($this->productsList[$i][2])) {
                        throw ValidationException::withMessages([
                            'price' => 'Price Doesn\'t Match what is already on the products\' list'
                        ]);
                    }
                    if ($this->quantity > (ProductDescription::find($this->product_id)->available_items - intval($this->productsList[$i][2]))) {
                        throw ValidationException::withMessages([
                            'quantity' => 'You have already reached your limit of items for this product'
                        ]);
                    }

                    $this->productsList[$i][1] += intval($this->quantity);
                    $count++;
                }
            }
        }
        if ($count == 0) {
            array_push($this->productsList, [intval($this->product_id), intval($this->quantity), intval($this->price)]);
        }
        $this->reset(['product_id', 'quantity', 'price']);
    }


    public function remove($key)
    {
        unset($this->productsList[$key]);
    }


    public function makeSale()
    {
        $this->validate();

        $this->sale->save();

        foreach ($this->productsList as $key => $item) {
            $productDescription = ProductDescription::find($item[0]);


            $count = 0;
            if ($item[1] > $productDescription->available_items) {
                $this->emit('done', [
                    'warning' => "The Number of Available Items is less than what you are selling here "
                ]);
                return;
            }
            foreach ($productDescription->productItems as $product_item) {
                if (!$product_item->is_sold) {
                    $product_item->sales()->attach($this->sale->id, [
                        'sale_price' => $item[2]
                    ]);
                    $count++;
                }

                if ($count == $item[1]) {
                    break;
                }
            }
        }


        $this->reset('productsList');

        $this->emit('done', [
            'success' => 'Successfully Made the Sale No. #' . $this->sale->id
        ]);
        $this->sale = new Sale();
    }

    public function render()
    {
        return view('livewire.admin.sales.create');
    }
}
