<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Meja;
use App\Models\Order;
use App\Models\Masakan;
use App\Models\Transaksi;
use App\Models\DetailOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function homepage() {
        $data = array(
            'title' => 'Kendedes Cafe',
        );

        return view('pelanggan.pages.homepage', $data);
    }

    public function menu(Request $request) {
        $filter = $request->tipe;
        $key = $request->query('key');
        $user = $request->user();

        if($filter) {
            $masakans = Masakan::orderBy('created_at', 'desc')
                                ->where('tipe', $filter)
                                ->get();
            $searched = Masakan::orderBy('created_at', 'desc')
                            ->where('tipe', $filter)
                            ->where('nama_masakan', 'LIKE', '%' . $key . '%')
                            ->get();
        } else {
            $masakans = Masakan::orderBy('created_at', 'desc')
                                ->get();
                                
            $searched = Masakan::orderBy('created_at', 'desc')
                                ->where('nama_masakan', 'LIKE', '%' . $key . '%')
                                ->get();
        }
        $mejas = Meja::orderBy('created_at', 'desc')
                    ->where('status', 'Tersedia')
                    ->get();
        
        if(Auth::check()) {
            $pending_order = Order::where('id_user', $user->id)
                            ->where('status', '!=', 'Completed')
                            ->count();

            if ($pending_order >= 1) {
                $order = Order::where('id_user', $user->id)
                            ->where('status', '!=', 'Completed')
                            ->first();
    
                $data = array(
                    'title' => 'Menu Masakan',
                    'mejas' => $mejas,
                    'masakans' => $masakans,
                    'masakans' => $searched,
                    'order' => $order,
                );
            } else {
    
                $data = array(
                    'title' => 'Menu Masakan',
                    'mejas' => $mejas,
                    'masakans' => $masakans,
                    'masakans' => $searched,
                );
            }   
        } else {

            $data = array(
                'title' => 'Menu Masakan',
                'mejas' => $mejas,
                'masakans' => $masakans,
                'masakans' => $searched,
            );
        }

        return view('pelanggan.pages.menu', $data)->with('no');
    }

    public function buat_order(Request $request) {
        $user = $request->user();

        $pending_order = Order::where('id_user', $user->id)
                                ->where('status', 'Pending')
                                ->count();
        if ($pending_order < 1) {
            $this->validate($request, [
                'id_meja' => 'required|numeric',
            ]);

            $ordercount = Order::count();
            if ($ordercount < 1) {
                $kode_order = 'ORD - 1';
            } else {
                $kode_order = 'ORD - ' . $ordercount + 1;
            }
            
            $input = $request->all();
            $input['kode_order'] = $kode_order;
            $input['tanggal'] = Carbon::now();
            $input['id_user'] = $user->id;
            $order = Order::create($input);

            if ($order) {
                $meja = Meja::findOrFail($request->id_meja);

                if ($meja->update(['status' => 'Terpakai'])) {
                    return back()->with('success', 'Order berhasil dibuat!');
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

    public function tambah_masakan(Request $request, $id) {
        $this->validate($request, [
            'id_order' => 'required',
            'qty' => 'required',
        ]);

        $order = Order::findOrFail($request->id_order);
        $masakan = Masakan::findOrFail($id);

        if ($request->qty > $masakan->stok) {
            return back()->with('error', 'Stock tidak mencukupi pesanan!');
        }

        $subtotal = $masakan->harga * $request->qty;
        $total = $order->total + $subtotal;

        if ($order->update(['total' => $total])) {
            $input = $request->all();
            $input['id_masakan'] = $masakan->id;
            $input['subtotal'] = $subtotal;
            $input['status'] = 'Pending';
            $detailorder = DetailOrder::create($input);

            if ($detailorder) {
                $newstok = $masakan->stok - $request->qty;
                if ($masakan->update(['stok' => $newstok])) {
                    if ($masakan->stok == 0) {
                        $masakan->update(['status' => 'Habis']);
                    }
                    return back();
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

    public function detailorder_delete($id) {
        $detailorder = DetailOrder::findOrFail($id);
        $order = $detailorder->order;
        $subtotal = $detailorder->subtotal;
        $newtotal = $order->total - $subtotal;

        if ($detailorder->delete()) {
            if ($order->update(['total' => $newtotal])) {
                if ($detailorder->masakan->update(['stok' => $detailorder->qty])) {
                    if ($detailorder->masakan->stok != 0) {
                        $detailorder->masakan->update(['status' => 'Tersedia']);
                    }
                    return back();
                }
            } else {
                return back()->with('error', 'Something went wrong!');
            }
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function ket_detail(Request $request, $id) {
        $detail = DetailOrder::findOrFail($id);

        if ($detail->update(['keterangan' => $request->keterangan])) {
            return back();
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function ket_order(Request $request, $id) {
        $order = Order::findOrFail($id);

        if ($order->update(['keterangan' => $request->keterangan])) {
            return back();
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function order_detail($id) {
        $order = Order::findOrFail($id);

        $data = array(
            'title' => 'Order Detail',
            'order' => $order,
        );

        return view('pelanggan.pages.order-detail', $data)->with('no');
    }

    public function order_submit(Request $request, $id) {
        $user = $request->user();
        $order = Order::findOrFail($id);

        if ($order->update(['status' => 'Menunggu Pembayaran'])) {

            $transaksicount = Transaksi::count();
            if ($transaksicount < 1) {
                $kode_transaksi = 'TRS - 1';
            } else {
                $kode_transaksi = 'TRS - ' . $transaksicount + 1;
            }

            $input['kode_transaksi'] = $kode_transaksi;
            $input['id_user'] = $user->id;
            $input['id_order'] = $order->id;
            $input['tanggal'] = Carbon::now();
            $input['total'] = $order->total;
            $transaksi = Transaksi::create($input);

            if ($transaksi) {
                return back();
            } else {
                return back()->with('error', 'Something went wrong!');
            }

        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
