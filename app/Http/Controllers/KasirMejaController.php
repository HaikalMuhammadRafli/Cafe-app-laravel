<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class KasirMejaController extends Controller
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

        return view('kasir.meja.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
