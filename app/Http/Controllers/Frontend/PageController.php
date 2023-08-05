<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\About;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display the product listing page.
     * Ürün listeleme sayfasını gösteren metot.
     */
    public function urunler(Request $request, $slug = null)
    {
        // URL'den kategori slug'ını alıyoruz
        $category = request()->segment(1) ?? null;

        // Filtreleme için boyutlar ve renkler
        $sizes = !empty($request->size) ? explode(',', $request->size) : null;
        $colors = !empty($request->color) ? explode(',', $request->color) : null;

        // Fiyat aralığı için başlangıç ve bitiş değerleri
        $startprice = $request->min ?? null;
        $endprice = $request->max ?? null;

        // Sıralama için kullanılan sütun ve sıralama yöntemi
        $order = $request->order ?? 'id';
        $sort = $request->sort ?? 'desc';

        // Ürünleri filtreleyerek, kategorisine göre listeliyoruz
        $products = Product::where('status', '1')
            ->select(['id', 'name', 'slug', 'size', 'color', 'price', 'category_id', 'image'])
            ->where(function ($q) use ($sizes, $colors, $startprice, $endprice) {
                if (!empty($sizes)) {
                    $q->whereIn('size', $sizes);
                }
                if (!empty($colors)) {
                    $q->whereIn('color', $colors);
                }
                if (!empty($startprice) && $endprice) {
                    $q->whereBetween('price', [$startprice, $endprice]);
                }
                return $q;
            })
            ->with('category:id,name,slug')
            ->whereHas('category', function ($q) use ($category, $slug) {
                if (!empty($slug)) {
                    $q->where('slug', $slug);
                }
                return $q;
            })
            ->orderBy($order, $sort)
            ->paginate(21);

        // Ajax isteği yapıldıysa ürün listesi ve sayfalama verilerini döndürüyoruz
        if ($request->ajax()) {
            $view = view('frontend.ajax.productList', compact('products'))->render();
            return response(['data' => $view, 'paginate' => (string) $products->withQueryString()->links('vendor.pagination.custom')]);
        }

        // Filtreleme için kullanılan seçenekleri alıyoruz
        $sizelists = Product::where('status', '1')->groupBy('size')->pluck('size')->toArray();
        $colors = Product::where('status', '1')->groupBy('color')->pluck('color')->toArray();

        // Maksimum fiyatı alıyoruz
        $maxprice = Product::max('price');

        return view('frontend.pages.products', compact('products', 'maxprice', 'sizelists', 'colors'));
    }

    /**
     * Display the product detail page.
     * Ürün detay sayfasını gösteren metot.
     */
    public function urundetay($slug)
    {
        $product = Product::whereSlug($slug)->where('status', '1')->firstOrFail();

        // Aynı kategoriye ait diğer ürünleri alıyoruz
        $products = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('status', '1')
            ->limit(6)
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.pages.product', compact('product', 'products'));
    }

    /**
     * Display the discounted products page.
     * İndirimdeki ürünler sayfasını gösteren metot.
     */
    public function indirimdekiurunler()
    {
        return view('frontend.pages.products');
    }

    /**
     * Display the about page.
     * Hakkımızda sayfasını gösteren metot.
     */
    public function hakkimizda()
    {
        $about = About::where('id', 1)->first();
        return view('frontend.pages.about', compact('about'));
    }

    /**
     * Display the contact page.
     * İletişim sayfasını gösteren metot.
     */
    public function iletisim()
    {
        return view('frontend.pages.contact');
    }

    /**
     * Display the catalog page.
     * Katalog sayfasını gösteren metot.
     */
    public function katalog()
    {
        return view('frontend.pages.katalog');
    }
}
