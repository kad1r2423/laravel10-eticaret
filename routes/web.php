<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PageHomeController;

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


// 'sitesetting' middleware'leriyle korunan rotaları gruplandıran bir Route grubu tanımlıyoruz
Route::group(['middleware'=>'sitesetting' ], function() {

    // Anasayfa rotası
    Route::get('/',[PageHomeController::class,'anasayfa'])->name ('anasayfa');

    Route::get('/urunler',[PageController::class,'urunler'])->name ('urunler');
    Route::get('/erkek/{slug?}',[PageController::class,'urunler'])->name ('erkekurunler');
    Route::get('/kadin/{slug?}',[PageController::class,'urunler'])->name ('kadinurunler');
    Route::get('/cocuk/{slug?}',[PageController::class,'urunler'])->name ('cocukurunler');
    Route::get('/indirimdekiler',[PageController::class,'indirimdekiurunler'])->name ('indirimdekiurunler');
    Route::get('/urun/{slug}',[PageController::class,'urundetay'])->name ('urundetay');
    Route::get('/hakkimizda',[PageController::class,'hakkimizda'])->name ('hakkimizda');
    Route::get('/iletisim',[PageController::class,'iletisim'])->name ('iletisim');
    Route::post('/iletisim/kaydet',[AjaxController::class,'iletisimkaydet'])->name ('iletisim.kaydet');
    Route::get('/katalog',[PageController::class,'katalog'])->name ('katalog');
    Route::get('/sepet',[CartController::class,'index'])->name ('sepet');
    Route::post('/sepet/ekle',[CartController::class,'add'])->name ('sepet.add');
    Route::post('/sepet/remove',[CartController::class,'remove'])->name ('sepet.remove');
    Route::post('/sepet/couponcheck',[CartController::class,'couponcheck'])->name ('coupon.check');

// Üye girişi rotaları
    Auth::routes();

// Çıkış rotası
    Route::get('/cikis',[AjaxController::class,'logout'])->name ('cikis');

});





