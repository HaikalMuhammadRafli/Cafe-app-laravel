<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->status;
        $key = $request->query('key');

        if ($filter) {
            $transaksis = Transaksi::orderBy('created_at', 'desc')
                                    ->where('status', $filter)
                                    ->get();

            $searched = Transaksi::orderBy('created_at', 'desc')
                                    ->where('kode_transaksi', 'LIKE', '%' . $key . '%')->where('status', $filter)
                                    ->orWhereHas('user', function ($q) use ($key) {
                                        $q->where('nama_user', 'like', '%' . $key . '%');
                                    })->where('status', $filter)
                                    ->orWhereHas('order', function ($q) use ($key) {
                                        $q->where('kode_order', 'like', '%' . $key . '%');
                                    })->where('status', $filter)
                                    ->get();
        } else {
            $transaksis = Transaksi::orderBy('created_at', 'desc')->get();

            $searched = Transaksi::orderBy('created_at', 'desc')
                                    ->where('kode_transaksi', 'LIKE', '%' . $key . '%')
                                    ->orWhereHas('user', function ($q) use ($key) {
                                        $q->where('nama_user', 'like', '%' . $key . '%');
                                    })
                                    ->orWhereHas('order', function ($q) use ($key) {
                                        $q->where('kode_order', 'like', '%' . $key . '%');
                                    })
                                    ->get();
        }
        $data = array(
            'title' => 'Data Transaksi',
            'transaksis' => $transaksis,
            'transaksis' => $searched,
        );

        return view('admin.transaksi.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        $order = $transaksi->order;
        $data = array(
            'title' => 'Data Transaksi',
            'transaksi' => $transaksi,
            'order' => $order,
        );

        return view('admin.transaksi.show', $data)->with('no');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $order = $transaksi->order;
        $meja = $order->meja;

        if ($transaksi->delete()) {
            if ($order->delete()) {
                $meja->update(['status' => 'Tersedia']);

                return back()->with('success', 'Transaksi berhasil dicancel!');
            } else {
                return back()->with('error', 'Something went wrong!');
            }
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function transaksi_bayar($id) {
        $transaksi = Transaksi::findOrFail($id);

        $order = $transaksi->order;

        $meja = $order->meja;

        if ($transaksi->update(['status' => 'Completed'])) {
            if ($order->update(['status' => 'Completed'])) {
                if ($meja->update(['status' => 'Tersedia'])) {
                    return back()->with('success', 'Pembayaran berhasil!');
                } else {
                    return back()->with('error', 'Something went wrong!');
                }             
            } else {
                return back()->with('error', 'Something went wrong!');
            }
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
