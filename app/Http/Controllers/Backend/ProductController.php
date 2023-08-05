<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Kayıtlı ürünleri listeleyen metot.
     */
    public function index()
    {
         $products = Product::with('category:id,cat_ust,name')->orderBy('id','desc')->paginate(20);
        return view('backend.pages.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * Yeni bir ürün oluşturmak için gerekli formu görüntüleyen metot.
     */
    public function create()
    {
        $categories = Category::get();
        return view('backend.pages.product.edit',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * Yeni bir ürünü veritabanına kaydeden metot.
     */
    public function store(ProductRequest $request)
    {

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $dosyadi = $request->name;
            $yukleKlasor = 'img/urun/';
            klasorac($yukleKlasor);
           // $resim->move(public_path('img/slider'),$dosyadi);
            $resimurl = resimyukle($image,$dosyadi,$yukleKlasor);
        }


        Product::create([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'content'=>$request->content,
            'short_text'=>$request->short_text,
            'price'=>$request->price,
            'size'=>$request->size,
            'color'=>$request->color,
            'qty'=>$request->qty,
            'image'=> $resimurl ?? NULL,
            'status'=>$request->status,

        ]);

        return back()->withSuccess('Başarıyla Oluşturuldu!');
    }

    /**
     * Display the specified resource.
     * Belirtilen ürünü görüntülemek için kullanılan metot.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Belirtilen ürünü düzenlemek için gerekli formu görüntüleyen metot.
     */
    public function edit(string $id)
    {
        $product = Product::where('id',$id)->first();
        $categories = Category::get();

        return view('backend.pages.product.edit',compact('product','categories'));

    }

    /**
     * Update the specified resource in storage.
     * Belirtilen ürünü veritabanında güncelleyen metot.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        $resimurl = $product->image;

        if ($request->hasFile('image')) {
            dosyasil($product->image);

            $image = $request->file('image');
            $dosyadi = $request->name;
            $yukleKlasor = 'img/urun/';
            klasorac($yukleKlasor);
            $resimurl = resimyukle($image, $dosyadi, $yukleKlasor);
        }


        $product->update([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'content'=>$request->content,
            'short_text'=>$request->short_text,
            'price'=>$request->price,
            'size'=>$request->size,
            'color'=>$request->color,
            'qty'=>$request->qty,
            'image'=> $resimurl ?? $product->image,
            'status'=>$request->status,
        ]);

        return back()->withSuccess('Başarıyla Güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     * Belirtilen ürünü veritabanından silen metot.
     */
    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->id);

        dosyasil($product->image);

        $product->delete();

        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    /**
     * Change the status of the specified resource.
     * Belirtilen ürünün durumunu değiştiren metot.
     */
    public function status(Request $request)
    {
        $update = $request->statu;
        $updatecheck = $update == "false" ? '0' : '1';
        Product::where('id', $request->id)->update(['status' => $updatecheck]);

        return response(['error' => false, 'status' => $update]);
    }
}
