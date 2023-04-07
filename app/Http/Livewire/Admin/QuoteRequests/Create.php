<?php

namespace App\Http\Livewire\Admin\QuoteRequests;

use App\Models\ActivityLog;
use App\Models\ProductDescription;
use App\Models\QuoteRequest;
use Livewire\Component;

class Create extends Component
{
    public $productDescriptions;

    public $productsList = [];
    public QuoteRequest $quoteRequest;

    protected $rules = [
        'quoteRequest.purchase_date' => 'required',
        'quoteRequest.supplier_id' => 'nullable',
    ];

    public $product_id, $quantity;


    public function mount()
    {
        // $this->middleware('permission:Create Purchases');
        $this->productDescriptions = ProductDescription::orderBy('brand_id','ASC')->get();
        $this->quoteRequest =  new QuoteRequest();
    }

    public function addToCart()
    {
        $this->validate([
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        $count = 0;
        if ($this->productsList) {


            for ($i = 0; $i < count($this->productsList); $i++) {
                if (intval($this->productsList[$i][0]) == intval($this->product_id) ) {
                    $this->productsList[$i][1] += intval($this->quantity);
                    $count++;
                }
            }
        }
        if ($count == 0) {
            array_push($this->productsList, [intval($this->product_id), intval($this->quantity)]);
        }
        $this->reset(['product_id', 'quantity']);
    }


    public function remove($key)
    {
        unset($this->productsList[$key]);
    }


    public function makePurchase()
    {
        $this->validate();
        $this->quoteRequest->user_id = auth()->user()->id;
        $this->quoteRequest->save();


        foreach ($this->productsList as $key => $item) {
            $this->quoteRequest->productDescriptions()->attach($item[0], [
                'quantity' => $item[1]
            ]);
        }


        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'payload' => "Created Quote Request No. " . $this->quoteRequest->id
        ]);



        $this->reset('productsList');

        $this->emit('done', [
            'success' => 'Successfully Made the Quote Request No. #' . $this->quoteRequest->id
        ]);
        $this->quoteRequest = new QuoteRequest();
    }
    public function render()
    {
        return view('livewire.admin.quote-requests.create');
    }
}
