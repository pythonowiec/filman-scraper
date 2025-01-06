<?php

use App\Livewire\Details;
use App\Livewire\Downloading;
use App\Livewire\Library;
use Illuminate\Support\Facades\Route;

Route::get('/', Library::class)->name('library');
Route::get('/downloading', Downloading::class)->name('downloading');
Route::get('/details/{title}', Details::class)->name('details');
