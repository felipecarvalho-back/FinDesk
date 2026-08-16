<?php

use App\Livewire\FinanceDashboard;
use App\Livewire\GlobalSettings;
use Illuminate\Support\Facades\Route;

Route::get('/', FinanceDashboard::class)->name('home');
Route::get('/settings', GlobalSettings::class)->name('settings');
