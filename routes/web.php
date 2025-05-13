<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductManageController;

// Route::get('/', function () {
//     return view('web.homepage');
// });

Route::get('/',[HomepageController::class,'index'])->name('home');
Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product']);
Route::get('categories',[HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);
Route::get('cart', [HomepageController::class, 'cart']);
Route::get('checkout', [HomepageController::class, 'checkout']);






// Route::get('/beauty', function () {
//     return view('beauty');
// });

// Route::get('products', function () {
//     return view('web.products');
// });

// Route::get('product/{slug}', function () {
//     return "INI ADALAH HALAMAN SINGLE PRODUK -".$slug;
// });

// Route::get('categories', function () {
//     return "INI ADALAH HALAMAN KATEGORI PRODUK ";
// });

// Route::get('category/{slug}', function () {
//     return "INI ADALAH HALAMAN SINGLE KATEGORI - ".$slug;
// });

// Route::get('cart', function () {
//     return "INI ADALAH HALAMAN CART ";
// });

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::group(['prefix'=>'dashboard'], function (){
    Route::resource('categories',ProductCategoryController::class);
});

Route::group(['prefix'=>'dashboard'], function (){
    Route::resource('product',ProductManageController::class);
});

// Route::group(['prefix'=>'dashboard'], function (){
//     Route::get('/',[DashboardController::class,'index'])->name('dashboard');
// })->middleware(['auth','verified']);


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
