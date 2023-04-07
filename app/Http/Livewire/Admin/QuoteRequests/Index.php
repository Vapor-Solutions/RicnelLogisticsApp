<?php

namespace App\Http\Livewire\Admin\QuoteRequests;

use App\Models\QuoteRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function delete($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Purchases')) {
            $this->emit('done', [
                'warning' => 'You are not permitted to delete the Purchases'
            ]);
            return;
        }
        $quoteRequest = QuoteRequest::find($id);
        $quoteRequest->productDescriptions()->detach();
        $quoteRequest->delete();

        $this->emit('done', [
            'success' => "Successfully Deleted that Purchase from the system"
        ]);
    }
    public function render()
    {
        return view('livewire.admin.quote-requests.index', [
            'quoteRequests' => QuoteRequest::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
