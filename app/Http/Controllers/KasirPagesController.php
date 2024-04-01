<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\User;
use App\Models\Masakan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirPagesController extends Controller
{
    public function dashboard() {
        $pelanggancount = User::where('id_level', 1)->count();
        $mejacount = Meja::count();
        $transaksicount = Transaksi::where('status', 'Menunggu Pembayaran')->count();

        $transaksis = Transaksi::orderBy('created_at', 'desc')
                                ->where('status', 'Menunggu Pembayaran')
                                ->get();
        $data = array(
            'title' => 'Admin Dashboard',
            'pelanggancount' => $pelanggancount,
            'mejacount' => $mejacount,
            'transaksicount' => $transaksicount,
            'transaksis' => $transaksis,
        );

        return view('kasir.pages.dashboard', $data)->with('no');
    }

    public function laporan() {
        $transaksis = Transaksi::orderBy('created_at', 'desc')
                                ->where('status', 'Completed')
                                ->get();
        $data = array(
            'title' => 'Admin Dashboard',
            'transaksis' => $transaksis,
        );

        return view('kasir.pages.laporan', $data)->with('no');
    }
}
