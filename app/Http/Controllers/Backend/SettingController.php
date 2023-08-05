<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Ayarları listeleme metodu
    public function index(){
        $settings = SiteSetting::get();
        return view ('backend.pages.setting.index', compact('settings'));
    }

    // Yeni ayar oluşturma metodu
    public function create(){
        return view ('backend.pages.setting.edit');
    }

    // Yeni ayarı kaydetme metodu
    public function store(Request $request){
        $key = $request->name;

        SiteSetting::firstOrCreate([
            'name' => $key,
        ], [
            'name' => $key,
            'data' => $request->data,
            'set_type' => $request->set_type,
        ]);
        return back()->withSuccess('Başarılı');
    }

    // Ayarı düzenleme metodu
    public function edit($id){
        $setting = SiteSetting::where('id', $id)->first();
        return view('backend.pages.setting.edit', compact('setting'));
    }

    // Ayarı güncelleme metodu
    public function update(Request $request, $id){
        $setting = SiteSetting::where('id', $id)->first();
        $key = $request->name;

        if ($request->hasFile('data')) {
            dosyasil($setting->data);

            $image = $request->file('data');
            $dosyadi =  $key;
            $yukleKlasor = 'img/setting/';

            klasorac( $yukleKlasor);
            $resimurl = resimyukle($image, $dosyadi, $yukleKlasor);
        }

        if($request->set_type == 'file' || $request->set_type == 'image'){
            $dataItem = $resimurl ?? $setting->data;
        }else {
            $dataItem = $request->data ?? $setting->data;

        }
        $setting->update([
            'name' => $key,
            'data' =>  $dataItem,
            'set_type' => $request->set_type,
        ]);
        return back()->withSuccess('Başarıyla Güncellendi   ');
        // Güncelleme işlemleri burada yapılacak
    }
}
