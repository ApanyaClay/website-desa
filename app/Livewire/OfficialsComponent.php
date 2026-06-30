<?php

namespace App\Livewire;

use App\Models\Official;
use Livewire\Component;

class OfficialsComponent extends Component
{
    public $search = '';
    public $selectedRole = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedRole' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        // Reset page if we had pagination (none here but good practice)
    }

    public function filterRole($role)
    {
        $this->selectedRole = $role;
    }

    public function render()
    {
        $query = Official::active()->ordered();

        if ($this->selectedRole !== 'all') {
            if ($this->selectedRole === 'pimpinan') {
                $query->where(function ($q) {
                    $q->where('role', 'Kepala Desa')
                      ->orWhere('role', 'Sekretaris Desa');
                });
            } elseif ($this->selectedRole === 'staf') {
                $query->where(function ($q) {
                    $q->where('role', 'like', 'Kaur%')
                      ->orWhere('role', 'like', 'Kasi%')
                      ->orWhere('role', 'like', 'Staf%');
                });
            } elseif ($this->selectedRole === 'kadus') {
                $query->where('role', 'like', 'Kepala Dusun%');
            }
        }

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $officials = $query->get();

        return view('livewire.officials-component', [
            'officials' => $officials,
        ]);
    }
}
