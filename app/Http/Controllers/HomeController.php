<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->user()->level->nama_level == 'Admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($request->user()->level->nama_level == 'Kasir') {
            return redirect()->route('kasir.dashboard');
        }

        return redirect()->route('home');
    }
}
