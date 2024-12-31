<?php

use App\Livewire\Downloading;
use App\Livewire\Library;
use Illuminate\Support\Facades\Route;

Route::get('/', Library::class)->name('library');
Route::get('/downloading', Downloading::class)->name('downloading');
Route::get('/download-movie', [\App\Services\MediaApiService::class, 'downloadMedia']);
