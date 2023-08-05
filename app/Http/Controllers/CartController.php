<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display the cart page with cart items and total price.
     * Sepet sayfasını, sepet öğeleri ve toplam fiyat ile birlikte görüntüler.
     */
    public function index()
    {
        $cartItem = session('cart', []);
        $totalPrice = 0;

        // Sepet öğeleri için toplam fiyatı hesapla
        foreach ($cartItem as $cart) {
            $totalPrice += $cart['price'] * $cart['qty'];
        }

        // Kupon varsa fiyatı kuponla düşür
        if (session()->has('coupon_code')) {
            $kupon = Coupon::where('name', session('coupon_code'))->where('status', '1')->first();
            $kuponprice = $kupon->price ?? 0;
            $newtotalPrice = $totalPrice - $kuponprice;
        } else {
            $newtotalPrice = $totalPrice;
        }

        // Toplam fiyatı güncelle
        session()->put('total_price', $newtotalPrice);

        return view('frontend.pages.cart', compact('cartItem'));
    }

    /**
     * Add a product to the cart.
     * Bir ürünü sepete ekler.
     */
    public function add(Request $request)
    {
        $productID = $request->product_id;
        $qty = $request->qty ?? 1;
        $size = $request->size;

        // Ürünü bul
        $urun = Product::find($productID);

        if (!$urun) {
            return back()->withError('Ürün Bulunamadı!');
        }

        $cartItem = session('cart', []);

        // Sepette ürün varsa miktarını artır, yoksa yeni ürün olarak ekle
        if (array_key_exists($productID, $cartItem)) {
            $cartItem[$productID]['qty'] += $qty;
        } else {
            $cartItem[$productID] = [
                'image' => $urun->image,
                'name' => $urun->name,
                'price' => $urun->price,
                'qty' => $qty,
                'size' => $size,
            ];
        }

        // Sepeti güncelle
        session(['cart' => $cartItem]);

        return back()->withSuccess('Ürün Sepete Eklendi!');
    }

    /**
     * Remove a product from the cart.
     * Bir ürünü sepetten kaldırır.
     */
    public function remove(Request $request)
    {
        $productID = $request->product_id;
        $cartItem = session('cart', []);

        // Sepette ürün varsa kaldır
        if (array_key_exists($productID, $cartItem)) {
            unset($cartItem[$productID]);
        }

        // Sepeti güncelle
        session(['cart' => $cartItem]);

        return back()->withSuccess('Başarıyla Sepetten Kaldırıldı!');
    }

    /**
     * Apply a coupon to the cart.
     * Sepete bir kupon uygular.
     */
    public function couponcheck(Request $request)
    {
        $cartItem = session('cart', []);
        $totalPrice = 0;

        // Sepet öğeleri için toplam fiyatı hesapla
        foreach ($cartItem as $cart) {
            $totalPrice += $cart['price'] * $cart['qty'];
        }

        // Kuponu bul
        $kupon = Coupon::where('name', $request->coupon_name)->where('status', '1')->first();

        if (empty($kupon)) {
            return back()->withError('Kupon Bulunamadı!');
        }

        $kuponprice = $kupon->price ?? 0;
        $newtotalPrice = $totalPrice - $kuponprice;

        // Toplam fiyatı güncelle ve kuponu kaydet
        session()->put('total_price', $newtotalPrice);
        session()->put('coupon_code', $kupon->name);

        return back()->withSuccess('Kupon Uygulandı!');
    }
}
