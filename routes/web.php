<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', App\Livewire\SelfOrder::class)->name('self-order');
Route::get('self-order', App\Livewire\SelfOrder::class)->name('self-order');

Route::get('product', App\Livewire\ProductList::class)->name('product');
Route::get('product/create', App\Livewire\ProductCreate::class);
Route::get('product/edit/{id}', App\Livewire\ProductEdit::class)->name('posts.edit');
Route::get('order', App\Livewire\OrderList::class)->name('order');
