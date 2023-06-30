<?php

namespace App\Http\Livewire\Admin\Sales;

use App\Imports\SalesImport;
use App\Models\ActivityLog;
use App\Models\ProductDescription;
use App\Models\ProductItem;
use App\Models\Sale;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Create extends Component
{
    use WithFileUploads;

    public $productDescriptions;

    public $file;

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
                    if ($this->price != floatval($this->productsList[$i][2])) {
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
            array_push($this->productsList, [intval($this->product_id), intval($this->quantity), floatval($this->price)]);
        }
        $this->reset(['product_id', 'quantity', 'price']);
    }


    public function remove($key)
    {
        array_splice($this->productsList, $key, 1);
    }


    public function makeSale()
    {
        $this->validate();

        $this->sale->save();

        foreach ($this->productsList as $item) {
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
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'payload' => "Created Sale No. " . $this->sale->id
        ]);
    }

    public function uploadFile()
    {
        // $file = $this->file->file('excel_file');

        // Validate the uploaded file if necessary
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv,txt'
        ]);

        // Store the uploaded file
        $filePath = $this->file->store('excel_files');

        // Import and parse the Excel data
        $import = new SalesImport();
        Excel::import($import, $filePath);

        // Access the parsed data
        $data = $import->getData();



        for ($i = 1; $i < count($data); $i++) {
            $dataValue = '%' . $data[$i][0] . '%';
            $desc = ProductDescription::where('title', 'like', $dataValue)->orWhereHas('brand', function ($query) use ($dataValue) {
                $query->where('name', 'like', $dataValue);
            })->orWhereHas('productCategory', function ($query) use ($dataValue) {
                $query->where('title', 'like', $dataValue);
            })->first();

            if ($desc) {
                array_push($this->productsList, [intval($desc->id), intval($data[$i][1]), floatval($data[$i][2])]);
            }

            // dd($data[$i][0]);
        }

        // Process the data as needed

        // Return a response or emit an event as required
        // dd($this->productsList);
    }

    public function render()
    {
        return view('livewire.admin.sales.create');
    }
}
