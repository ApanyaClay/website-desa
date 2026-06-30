<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Component;

class GalleriesComponent extends Component
{
    public $selectedGalleryId = null;
    public $activePhotoIndex = null; // for lightbox

    protected $queryString = [
        'selectedGalleryId' => ['except' => null],
    ];

    public function selectGallery($id)
    {
        $this->selectedGalleryId = $id;
        $this->activePhotoIndex = null;
    }

    public function resetSelection()
    {
        $this->selectedGalleryId = null;
        $this->activePhotoIndex = null;
    }

    public function openLightbox($index)
    {
        $this->activePhotoIndex = $index;
    }

    public function closeLightbox()
    {
        $this->activePhotoIndex = null;
    }

    public function nextPhoto()
    {
        if ($this->selectedGalleryId && $this->activePhotoIndex !== null) {
            $gallery = Gallery::with('items')->find($this->selectedGalleryId);
            $count = $gallery->items->count();
            if ($count > 0) {
                $this->activePhotoIndex = ($this->activePhotoIndex + 1) % $count;
            }
        }
    }

    public function prevPhoto()
    {
        if ($this->selectedGalleryId && $this->activePhotoIndex !== null) {
            $gallery = Gallery::with('items')->find($this->selectedGalleryId);
            $count = $gallery->items->count();
            if ($count > 0) {
                $this->activePhotoIndex = ($this->activePhotoIndex - 1 + $count) % $count;
            }
        }
    }

    public function render()
    {
        $galleries = Gallery::with('items')->latest()->get();
        
        $selectedGallery = null;
        if ($this->selectedGalleryId) {
            $selectedGallery = Gallery::with('items')->find($this->selectedGalleryId);
        }

        return view('livewire.galleries-component', [
            'galleries' => $galleries,
            'selectedGallery' => $selectedGallery,
        ]);
    }
}
