<?php

namespace App\Livewire\Admin;

use App\Models\PaymentMethod;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class PaymentMethods extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $address = '';

    public string $slug = '';

    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
    ];

    public function createNewPaymentMethod()
    {
        try {
            $this->validate();
            $imagePath = $this->image->store('payment-method-icon', 'public');

            PaymentMethod::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'address' => $this->address,
                'icon_url' => $imagePath,
            ]);

            session()->flash(
                'success-message',
                'Payment method created successfully',
            );
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function destroyStrategy(int $methodId)
    {
        try {
            PaymentMethod::destroy($methodId);
            session()->flash(
                'success-message',
                'Payment method deleted successfully',
            );
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function render()
    {
        $paymentMethods = PaymentMethod::all();

        return view('livewire.admin.payment-methods', [
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
