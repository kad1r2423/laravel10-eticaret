<?php

namespace App\Http\Controllers\Frontend;

use App\Models\About;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageHomeController extends Controller
{
    /**
     * Display the homepage.
     * Anasayfayı gösteren metot.
     */
    public function anasayfa()
    {
        // Slider'dan aktif olan ilk slaytı alıyoruz
        $slider = Slider::where('status', '1')->first();

        // Sayfa başlığı için değişken
        $title = "Anasayfa";

        // Hakkımızda içeriğini alıyoruz
        $about = About::where('id', 1)->first();

        $lastproducts = Product::where('status','1')->select(['id','name','slug','size','color','price','category_id','image'])->with('category')->orderBy('id','desc')->limit(10)->get();

        // Anasayfayı görüntülemek için view'a verileri gönderiyoruz
        return view('frontend.pages.index', compact('slider', 'title', 'about','lastproducts'));
    }
}
