<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mejas = Meja::orderBy('created_at', 'desc')->paginate(20);
        $data = array(
            'title' => 'Data Meja',
            'mejas' => $mejas,
        );

        return view('admin.meja.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
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
        $this->validate($request, [
            'nomor_meja' => 'required',
            'kapasitas' => 'required',
        ]);

        $input = $request->all();
        $meja = Meja::create($input);

        if ($meja) {
            return back()->with('success', 'Meja berhasil ditambahkan!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Meja $meja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meja $meja)
    {
        $data = array(
            'title' => 'Edit Meja',
            'meja' => $meja,
        );

        return view('admin.meja.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meja $meja)
    {
        $this->validate($request, [
            'nomor_meja' => 'required',
            'kapasitas' => 'required',
        ]);

        $input = $request->all();

        if ($meja->update($input)) {
            return redirect()->route('meja.index')->with('success', 'Meja berhasil diedit!');
        } else {
            return redirect()->route('meja.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meja $meja)
    {
        if ($meja->delete()) {
            return back()->with('success', 'Meja berhasil dihapus');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function meja_tersedia($id) {
        $meja = Meja::findOrFail($id);

        if ($meja->update(['status' => 'Tersedia'])) {
            return back()->with('success', 'Status meja tersedia!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    public function meja_terpakai($id) {
        $meja = Meja::findOrFail($id);

        if ($meja->update(['status' => 'Terpakai'])) {
            return back()->with('success', 'Status meja terpakai!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
