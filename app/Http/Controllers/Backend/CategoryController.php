<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * Tüm kategorileri listeleme metodu.
     */
    public function index()
    {
         $categories = Category::with('category:id,cat_ust,name')->get();
        return view('backend.pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * Yeni bir kayıt oluşturma formunu gösterme metodu.
     */
    public function create()
    {
        $categories = Category::get();
        return view('backend.pages.category.edit', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * Yeni bir kaydı veritabanına kaydetme metodu.
     */
    public function store(CategoryRequest $request)
    {
        // Eğer bir resim yüklendi ise
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $dosyadi = $request->name;
            $yukleKlasor = 'img/kategori/';
            // resimyukle() fonksiyonu, resmi yüklemek ve URL'sini döndürmek için kullanılıyor
            $resimurl = resimyukle($image, $dosyadi, $yukleKlasor);
        }

        // Yeni kategori oluştur
        Category::create([
            'name' => $request->name,
            'cat_ust' => $request->cat_ust,
            'status' => $request->status,
            'content' => $request->content,
            'image' => $resimurl ?? NULL,
        ]);

        return back()->withSuccess('Başarıyla Oluşturuldu!');
    }

    /**
     * Show the form for editing the specified resource.
     * Belirtilen kaydı düzenleme formunu gösterme metodu.
     */
    public function edit(string $id)
    {
        $category = Category::where('id', $id)->first();
        $categories = Category::get();

        return view('backend.pages.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * Belirtilen kaydı güncelleme metodu.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $resimurl = $category->image;

        // Eğer bir resim yüklendi ise
        if ($request->hasFile('image')) {
            dosyasil($category->image);

            $image = $request->file('image');
            $dosyadi = $request->name;
            $yukleKlasor = 'img/kategori/';
            $resimurl = resimyukle($image, $dosyadi, $yukleKlasor);
        }

        // Kategoriyi güncelle
        $category->update([
            'name' => $request->name,
            'cat_ust' => $request->cat_ust,
            'status' => $request->status,
            'content' => $request->content,
            'image' => $resimurl ?? $category->image,
        ]);

        return back()->withSuccess('Başarıyla Güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     * Belirtilen kaydı veritabanından silme metodu.
     */
    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);

        // İlgili resmi sil
        dosyasil($category->image);

        $category->delete();

        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    /**
     * Update the status of the specified resource.
     * Belirtilen kaydın durumunu güncelleme metodu.
     */
    public function status(Request $request)
    {
        $update = $request->statu;
        $updatecheck = $update == "false" ? '0' : '1';
        Category::where('id', $request->id)->update(['status' => $updatecheck]);

        return response(['error' => false, 'status' => $update]);
    }
}
