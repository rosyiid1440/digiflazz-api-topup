<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

route::get('kategori',[App\Http\Controllers\Api\KategoriController::class,'index']);
route::get('kategori/{slug}/brand',[App\Http\Controllers\Api\KategoriController::class,'brand']);
route::get('produk/{slugkategori}/{slugproduk}',[App\Http\Controllers\Api\KategoriController::class,'produk']);

route::post('topup',[App\Http\Controllers\Api\TransaksiController::class,'topup']);