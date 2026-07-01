<?php

namespace App\Livewire\Admin;

use App\Models\Strategy;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class AdminStrategy extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $duration = '';

    public string $minimumAmount = '';

    public string $maximumAmount = '';

    public string $minimumROI = '';

    public string $maximumROI = '';

    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'duration' => 'required|string|max:255',
        'minimumAmount' => 'required|numeric',
        'maximumAmount' => 'required|numeric',
        'minimumROI' => 'required|numeric',
        'maximumROI' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
    ];

    public function createNewStrategy()
    {
        try {
            $this->validate();
            $imagePath = $this->image->store('strategy-image', 'public');

            Strategy::create([
                'name' => $this->name,
                'min_amount' => $this->minimumAmount,
                'max_amount' => $this->maximumAmount,
                'min_roi' => $this->minimumROI,
                'max_roi' => $this->maximumROI,
                'image_url' => $imagePath,
                'status' => 'active',
                'duration' => $this->duration,
            ]);

            session()->flash(
                'success-message',
                'Strategy created successfully',
            );
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function destroyStrategy(int $strategyId)
    {
        try {
            Strategy::destroy($strategyId);
            session()->flash(
                'success-message',
                'Strategy deleted successfully',
            );
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function render()
    {
        $strategies = Strategy::all();

        return view('livewire.admin.admin-strategy', [
            'strategies' => $strategies,
        ]);
    }
}
