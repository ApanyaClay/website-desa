<?php

namespace App\Livewire;

use App\Models\Potency;
use Livewire\Component;

class PotenciesComponent extends Component
{
    public $search = '';
    public $selectedCategory = 'all';
    public $perPage = 6;
    
    // For the detail modal
    public $selectedPotencyId = null;
    public $isModalOpen = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->perPage = 6;
    }

    public function filterCategory($category)
    {
        $this->selectedCategory = $category;
        $this->perPage = 6;
    }

    public function loadMore()
    {
        $this->perPage += 6;
    }

    public function openDetail($id)
    {
        $this->selectedPotencyId = $id;
        $this->isModalOpen = true;
    }

    public function closeDetail()
    {
        $this->isModalOpen = false;
        $this->selectedPotencyId = null;
    }

    public function render()
    {
        $query = Potency::query();

        if ($this->selectedCategory !== 'all') {
            $query->category($this->selectedCategory);
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%');
            });
        }

        $totalCount = $query->count();
        $potencies = $query->latest()->take($this->perPage)->get();
        
        $selectedPotency = null;
        if ($this->selectedPotencyId) {
            $selectedPotency = Potency::find($this->selectedPotencyId);
        }

        return view('livewire.potencies-component', [
            'potencies' => $potencies,
            'totalCount' => $totalCount,
            'selectedPotency' => $selectedPotency,
            'hasMore' => $totalCount > $this->perPage,
        ]);
    }
}
