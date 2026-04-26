<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;


Route::resource('index', ProdukController::class);

Route::get('/', [ProdukController::class, 'index']);

route::post('/produk/store', [ProdukController::class, 'store'])->name('index.store');
route::get('/produk/edit{id}', [ProdukController::class, 'edit'])->name('index.edit');
route::put('/produk/update{id}', [ProdukController::class, 'update'])->name('index.update');
route::delete('/produk/delete{id}', [ProdukController::class, 'destroy'])->name('index.destroy');
