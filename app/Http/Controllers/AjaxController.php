<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ContentFormRequest;

class AjaxController extends Controller
{
    /**
     * Save the contact form data using AJAX.
     * İletişim formu verilerini AJAX kullanarak kaydeden metot.
     */
    public function iletisimkaydet(ContentFormRequest $request)
    {
        // Form verilerini alıyoruz ve düzenliyoruz
        $newdata = [
            'name' => Str::title($request->name),
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip' => request()->ip(),
        ];

        // Verileri kullanarak yeni bir iletişim nesnesi oluşturuyoruz
        $sonkaydedilen = Contact::create($newdata);

        // Başarı mesajıyla birlikte geri dönüyoruz
        return back()->withSuccess(['message' => 'Başarıyla Gönderildi']);
    }

    /**
     * Log the user out and redirect to the homepage.
     * Kullanıcıyı oturumdan çıkartır ve anasayfaya yönlendirir.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('anasayfa');
    }
}
