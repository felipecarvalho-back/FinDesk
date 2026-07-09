<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\FinanceDashboard;

Route::get('/', FinanceDashboard::class)->name('home');
