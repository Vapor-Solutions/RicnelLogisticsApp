<?php

namespace App\Http\Livewire\Admin\Invoices;

use App\Models\ActivityLog;
use App\Models\Invoice;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // $this->middleware('permission:Delete Invoices')->only('delete');
    }
    public function delete($id)
    {
        // $invoice = Invoice::find($id);
        // $invoice->delete();

        // ActivityLog::create([
        //     'user_id' => auth()->user()->id,
        //     'payload' => "Deleted Invoice No. $invoice->id"
        // ]);

        // $this->emit('done', [
        //     'success' => 'Successfully Deleted the Invoice'
        // ]);
        $this->emit('done', [
            'info' => 'Invoice Deletion has now been disabled'
        ]);
    }

    public function render()
    {

        return view('livewire.admin.invoices.index', [
            'invoices' => Invoice::orderBy('id','DESC')->paginate(10)
        ]);
    }
}
