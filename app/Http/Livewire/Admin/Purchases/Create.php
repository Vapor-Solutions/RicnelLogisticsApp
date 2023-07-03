<?php

namespace App\Http\Livewire\Admin\Purchases;

use App\Imports\SalesImport;
use App\Models\ActivityLog;
use App\Models\ProductDescription;
use App\Models\ProductItem;
use App\Models\Purchase;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Create extends Component
{
    use WithFileUploads;
    public $productDescriptions;

    public $file;


    public $productsList = [];
    public Purchase $purchase;

    protected $rules = [
        'purchase.purchase_date' => 'required',
        'purchase.supplier_id' => 'required',
    ];

    public $product_id, $quantity, $price;


    public function mount()
    {
        // $this->middleware('permission:Create Purchases');
        $this->productDescriptions = ProductDescription::all();
        $this->purchase =  new Purchase();
    }

    public function addToCart()
    {
        $this->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        $count = 0;
        if ($this->productsList) {


            for ($i = 0; $i < count($this->productsList); $i++) {
                if (intval($this->productsList[$i][0]) == intval($this->product_id) && intval($this->productsList[$i][2]) == floatval($this->price)) {
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
        unset($this->productsList[$key]);
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

        // dd($data);

        $values = [];

        foreach ($data as $item) {
            if ($item[0] != null) {
                array_push($values, [$item[0], $item[1], $item[2]]);
            }
        }

        // dd($test);

        for ($i = 1; $i < count($values); $i++) {
            $dataValue = '%' . $values[$i][0] . '%';
            $desc = ProductDescription::where('title', 'like', $dataValue)->orWhereHas('brand', function ($query) use ($dataValue) {
                $query->where('name', 'like', $dataValue);
            })->orWhereHas('productCategory', function ($query) use ($dataValue) {
                $query->where('title', 'like', $dataValue);
            })->first();

            if ($desc) {
                array_push($this->productsList, [intval($desc->id), intval($data[$i][1]), floatval($data[$i][2])]);
            }
        }

        if (count($this->productsList) == 0) {
            $this->emit('done', [
                'info' => 'There were no items that matched the system database'
            ]);
        }
        unlink($filePath);
    }



    public function makePurchase()
    {
        $this->validate();

        $this->purchase->save();


        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'payload' => "Created Purchase No. " . $this->purchase->id
        ]);

        foreach ($this->productsList as $key => $item) {
            for ($i = 0; $i < $item[1]; $i++) {
                $product_item = new ProductItem();
                $product_item->product_description_id = $item[0];
                $product_item->price = $item[2];
                $product_item->sku_number = Str::random(9);
                $product_item->save();
                $product_item->purchases()->attach($this->purchase->id);
            }
        }


        $this->reset('productsList');

        $this->emit('done', [
            'success' => 'Successfully Made the Purchase No. #' . $this->purchase->id
        ]);
        $this->purchase = new Purchase();
    }


    public function render()
    {
        return view('livewire.admin.purchases.create');
    }
}
