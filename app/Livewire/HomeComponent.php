<?php

namespace App\Livewire;

use App\Models\Profile;
use App\Models\Potency;
use App\Models\Gallery;
use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        $profile = Profile::first() ?? new Profile([
            'nama_desa' => 'Desa Mekar Jaya',
            'sejarah' => 'Sejarah desa belum diisi.',
            'visi' => 'Visi belum diisi.',
            'misi' => 'Misi belum diisi.',
        ]);

        $featuredPotencies = Potency::latest()->take(3)->get();
        $recentGalleries = Gallery::with('items')->latest()->take(3)->get();

        return view('livewire.home-component', [
            'profile' => $profile,
            'featuredPotencies' => $featuredPotencies,
            'recentGalleries' => $recentGalleries,
        ]);
    }
}
