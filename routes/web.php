<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\HomeComponent;
use App\Livewire\OfficialsComponent;
use App\Livewire\PotenciesComponent;
use App\Livewire\GalleriesComponent;

Route::get('/', HomeComponent::class)->name('home');
Route::get('/aparat', OfficialsComponent::class)->name('officials');
Route::get('/potensi', PotenciesComponent::class)->name('potencies');
Route::get('/galeri', GalleriesComponent::class)->name('galleries');

