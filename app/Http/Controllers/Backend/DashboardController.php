<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     * Yönetici panelinin anasayfasını görüntüleme metodu.
     */
    public function index()
    {
        // 'backend.pages.index' şablonunu görüntüle, bu sayfada genellikle yönetici panelinin ana içeriği yer alır.
        return view('backend.pages.index');
    }
}
