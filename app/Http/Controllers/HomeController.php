<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard for user role.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Di sini, Anda dapat menambahkan logika lain jika diperlukan.
        return view('user.home');
    }
}
