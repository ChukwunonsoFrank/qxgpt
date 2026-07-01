<?php

namespace App\Livewire\Admin;

use App\Models\Strategy;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class AdminStrategyDetails extends Component
{
    use WithFileUploads;

    #[Url]
    public $id;

    public string $name = '';

    public string $duration = '';

    public string $minimumAmount = '';

    public string $maximumAmount = '';

    public string $minimumROI = '';

    public string $maximumROI = '';

    public string $previousImageUrl = '';

    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'duration' => 'required|string|max:255',
        'minimumAmount' => 'required|numeric',
        'maximumAmount' => 'required|numeric',
        'minimumROI' => 'required|numeric',
        'maximumROI' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
    ];

    public function updateStrategy(int $strategyId)
    {
        try {
            $this->validate();
            $imagePath = $this->image
                ? $this->image->store('strategy-image', 'public')
                : $this->previousImageUrl;

            Strategy::where('id', '=', $strategyId, 'and')->update([
                'name' => $this->name,
                'min_amount' => $this->minimumAmount,
                'max_amount' => $this->maximumAmount,
                'min_roi' => $this->minimumROI,
                'max_roi' => $this->maximumROI,
                'image_url' => $imagePath,
                'duration' => $this->duration,
            ]);

            session()->flash(
                'success-message',
                'Strategy updated successfully',
            );
        } catch (\Exception $e) {
            session()->flash('error-message', $e->getMessage());
        }
    }

    public function render()
    {
        $strategy = Strategy::where('id', '=', $this->id, 'and')->first();

        $this->name = $strategy['name'];
        $this->minimumAmount = $strategy['min_amount'];
        $this->maximumAmount = $strategy['max_amount'];
        $this->minimumROI = $strategy['min_roi'];
        $this->maximumROI = $strategy['max_roi'];
        $this->duration = $strategy['duration'];
        $this->previousImageUrl = $strategy['image_url'];

        return view('livewire.admin.admin-strategy-details');
    }
}
