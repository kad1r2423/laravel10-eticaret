<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     * İletişim mesajlarının listesini görüntüleme metodu.
     */
    public function index()
    {
        // Sayfalama yapılarak tüm iletişim mesajlarını getir.
        $contacts = Contact::paginate(1);
        return view('backend.pages.contact.index', compact('contacts'));
    }

    /**
     * Show the form for editing the specified contact.
     * Belirtilen iletişim mesajını düzenleme formunu gösterme metodu.
     */
    public function edit($id)
    {
        // İlgili iletişim mesajını id'ye göre bul ve düzenleme sayfasına gönder.
        $contact = Contact::where('id', $id)->firstOrFail();
        return view('backend.pages.contact.edit', compact('contact'));
    }

    /**
     * Update the specified contact in storage.
     * Belirtilen iletişim mesajını veritabanında güncelleme metodu.
     */
    public function update($id)
    {
        // Bu kısımda güncelleme işlemlerini gerçekleştir, ancak burada kod yok.
        // Çünkü 'update' işlemini gerçekleştirecek kod eksik. Bu metodu tamamlayarak kullanabilirsiniz.
    }

    /**
     * Remove the specified contact from storage.
     * Belirtilen iletişim mesajını veritabanından silme metodu.
     */
    public function destroy(Request $request)
    {
        // İletişim mesajını id'ye göre bul ve sil.
        $contact = Contact::findOrFail($request->id);
        $contact->delete();

        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    /**
     * Update the status of the specified contact.
     * Belirtilen iletişim mesajının durumunu güncelleme metodu.
     */
    public function status(Request $request)
    {
        // İletişim mesajının durumunu güncelle (aktif veya pasif yap).
        $update = $request->statu;
        $updatecheck = $update == "false" ? '0' : '1';
        Contact::where('id', $request->id)->update(['status' => $updatecheck]);

        return response(['error' => false, 'status' => $update]);
    }
}
