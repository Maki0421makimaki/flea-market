<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\SellController;

Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('product.show');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'show']);

    Route::post('/mypage', [ProfileController::class, 'store']);

    Route::post('/product/{id}/like', [ItemController::class, 'like']);

    Route::post('/product/{id}/unlike', [ItemController::class, 'unlike']);

    Route::post('/product/{id}/comment', [ItemController::class, 'store']);

    Route::get('/purchase/{item_id}',[PurchaseController::class,'show'])->name('product.purchase');

    Route::post('/purchase/{item_id}', [PurchaseController::class, 'buy'])->name('purchase.buy');

    Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success'])->name('purchase.success');

    Route::get('/purchase/address/{item_id}',[AddressController::class,'edit']);

    Route::post('/purchase/address/{item_id}', [AddressController::class, 'update']);


    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');

    Route::get('/mypage/profile', [ProfileController::class, 'edit']);

    Route::post('/mypage', [ProfileController::class, 'update']);

    // 出品
    Route::get('/sell', [SellController::class, 'show']);

    Route::post('/sell', [SellController::class, 'create']);

});
