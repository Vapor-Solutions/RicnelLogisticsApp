<?php

namespace App\Http\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Sale;
use App\Models\ProductDescription;
use App\Models\ProductItem;
use App\Models\Purchase;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $products = [];
    public $departments = [];
    public $inventory_value = 0;
    public $purchasesThisMonth = [];
    public $salesThisMonth = [];
    public $purchasevalue = 0;
    public $saleValue = 0;


    public $readyToLoad = false;

    public function loadStuff()
    {
        $this->products = ProductItem::select(['id', 'product_description_id', 'price'])->get();
        $this->departments = Department::all();
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $this->purchasesThisMonth = Purchase::whereBetween('purchase_date', [$start, $end])->get();
        $this->salesThisMonth = Sale::whereBetween('sale_date', [$start, $end])->get();

        foreach ($this->purchasesThisMonth as $purchase) {
            $this->purchasevalue += $purchase->total_cost;
        }
        foreach ($this->salesThisMonth as $sale) {
            $this->saleValue += $sale->total_cost;
        }


        foreach ($this->products as $product) {
            $this->inventory_value += $product->price;
        }

        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'activities' => $this->readyToLoad ? ActivityLog::orderBy('created_at', 'DESC')->paginate(5) : []
        ]);
        // dd(ProductItem::with('productDescription')->limit(5)->get());
    }
}
