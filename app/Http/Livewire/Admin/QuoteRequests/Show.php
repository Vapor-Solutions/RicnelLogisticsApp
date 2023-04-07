<?php

namespace App\Http\Livewire\Admin\QuoteRequests;

use App\Models\QuoteRequest;
use Livewire\Component;

class Show extends Component
{
    public QuoteRequest $quoteRequest;

    public function mount($id)
    {
        $this->quoteRequest = QuoteRequest::find($id);
    }
    public function render()
    {
        return view('livewire.admin.quote-requests.show');
    }
}
