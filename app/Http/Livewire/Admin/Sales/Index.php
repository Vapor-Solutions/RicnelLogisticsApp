<?php

namespace App\Http\Livewire\Admin\Sales;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function delete($id)
    {
        $sale= Sale::find($id);
        if ($sale->invoice != null) {
            $this->emit('done', [
                'warning'=>"This Sale has Already Been Invoiced"
            ]);
        }

        $sale->productItems()->detach();
        $sale->delete();

        $this->emit('done', [
            'success'=>"Successfully Deleted that Sale from the system"
        ]);
    }

    public function render()
    {
        return view('livewire.admin.sales.index', [
            'sales' => Sale::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
