<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Requests\SliderRequest;
use ImageResize;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     * Kayıtlı sliderları listeleyen metot.
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('backend.pages.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     * Yeni bir slider oluşturmak için gerekli formu görüntüleyen metot.
     */
    public function create()
    {
        return view('backend.pages.slider.edit');
    }

    /**
     * Store a newly created resource in storage.
     * Yeni bir sliderı veritabanına kaydeden metot.
     */
    public function store(SliderRequest $request)
    {

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $dosyadi = $request->name;
            $yukleKlasor = 'img/slider/';
           // $resim->move(public_path('img/slider'),$dosyadi);
            $resimurl = resimyukle($image,$dosyadi,$yukleKlasor);
        }

        Slider::create([
            'name'=>$request->name,
            'link'=>$request->link,
            'content'=>$request->content,
            'status'=>$request->status,
            'image'=> $resimurl ?? NULL,
        ]);

        return back()->withSuccess('Başarıyla Oluşturuldu!');
    }

    /**
     * Display the specified resource.
     * Belirtilen sliderı görüntülemek için kullanılan metot.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Belirtilen sliderı düzenlemek için gerekli formu görüntüleyen metot.
     */
    public function edit(string $id)
    {
        $slider = Slider::where('id',$id)->first();
        return view('backend.pages.slider.edit',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     * Belirtilen sliderı veritabanında güncelleyen metot.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);

        $resimurl = $slider->image;

        if ($request->hasFile('image')) {
            dosyasil($slider->image);

            $image = $request->file('image');
            $dosyadi = $request->name;
            $yukleKlasor = 'img/slider/';
            $resimurl = resimyukle($image, $dosyadi, $yukleKlasor);
        }

        $slider->update([
            'name' => $request->name,
            'link' => $request->link,
            'content' => $request->content,
            'status' => $request->status,
            'image' => $resimurl ?? $slider->image,
        ]);

        return back()->withSuccess('Başarıyla Güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     * Belirtilen sliderı veritabanından silen metot.
     */
    public function destroy(Request $request)
    {
        $slider = Slider::findOrFail($request->id);

        dosyasil($slider->image);

        $slider->delete();

        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    /**
     * Change the status of the specified resource.
     * Belirtilen sliderın durumunu değiştiren metot.
     */
    public function status(Request $request)
    {
        $update = $request->statu;
        $updatecheck = $update == "false" ? '0' : '1';
        Slider::where('id', $request->id)->update(['status' => $updatecheck]);

        return response(['error' => false, 'status' => $update]);
    }

}
