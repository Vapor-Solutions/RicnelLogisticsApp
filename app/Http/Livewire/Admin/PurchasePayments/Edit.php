<?php

namespace App\Http\Livewire\Admin\PurchasePayments;

use App\Models\PurchasePayment;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Edit extends Component
{
    public PurchasePayment $payment;
    public $old_amount;

    protected $rules = [
        'payment.purchase_id' => 'required',
        'payment.payment_method_id' => 'required',
        'payment.amount' => 'required',
    ];

    public function mount($id)
    {
        $this->payment = PurchasePayment::find($id);
        $this->old_amount = $this->payment->amount;
    }


    public function save()
    {
        $this->validate();


        if ($this->payment->amount > ($this->payment->purchase->balance + $this->old_amount)) {
            throw ValidationException::withMessages([
                'payment.amount' => "The Value of this Payment can not be more than the balance of the Purchase that's being paid for"
            ]);
        }

        $this->payment->save();


        return redirect()->route('admin.purchase-payments.index');
    }
    public function render()
    {
        return view('livewire.admin.purchase-payments.edit');
    }
}
