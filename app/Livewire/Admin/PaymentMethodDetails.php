<?php

namespace App\Livewire\Admin;

use App\Models\PaymentMethod;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class PaymentMethodDetails extends Component
{
    use WithFileUploads;

    #[Url]
    public $id;

    public string $name = '';

    public string $address = '';

    public string $slug = '';

    public string $previousImageUrl = '';

    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
    ];

    public function updatePaymentMethod(int $methodId)
    {
        try {
            $this->validate();
            $imagePath = $this->image
                ? $this->image->store('payment-method-icon', 'public')
                : $this->previousImageUrl;

            PaymentMethod::where('id', '=', $methodId, 'and')->update([
                'name' => $this->name,
                'address' => $this->address,
                'slug' => $this->slug,
                'icon_url' => $imagePath,
            ]);

            session()->flash(
                'success-message',
                'Payment method updated successfully',
            );
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function render()
    {
        $paymentMethod = PaymentMethod::where(
            'id',
            '=',
            $this->id,
            'and',
        )->first();

        $this->name = $paymentMethod['name'];
        $this->address = $paymentMethod['address'];
        $this->slug = $paymentMethod['slug'];
        $this->previousImageUrl = $paymentMethod['icon_url'];

        return view('livewire.admin.payment-method-details');
    }
}
