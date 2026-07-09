<?php

use App\Livewire\FinanceDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', FinanceDashboard::class)->name('home');
