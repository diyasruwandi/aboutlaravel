<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('web.homepage');
});

Route::get('/beauty', function () {
    return view('beauty');
});

Route::get('products', function () {
    return view('web.products');
});

Route::get('product/{slug}', function () {
    return "INI ADALAH HALAMAN SINGLE PRODUK -".$slug;
});

Route::get('categories', function () {
    return "INI ADALAH HALAMAN KATEGORI PRODUK ";
});

Route::get('category/{slug}', function () {
    return "INI ADALAH HALAMAN SINGLE KATEGORI - ".$slug;
});

Route::get('cart', function () {
    return "INI ADALAH HALAMAN CART ";
});

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
