<?php

namespace App\Http\Controllers;

use App\Models\Masakan;
use Illuminate\Http\Request;

class MasakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->tipe;
        $key = $request->query('key');

        if ($filter) {
            $masakans = Masakan::orderBy('created_at', 'desc')
                                ->where('tipe', $filter)
                                ->paginate(20);

            $searched = Masakan::orderBy('created_at', 'desc')
                                ->where('tipe', $filter)
                                ->where('nama_masakan', 'LIKE', '%' . $key . '%')
                                ->paginate(20);
        } else {
            $masakans = Masakan::orderBy('created_at', 'desc')->paginate(20);

            $searched = Masakan::orderBy('created_at', 'desc')
                                ->where('nama_masakan', 'LIKE', '%' . $key . '%')
                                ->paginate(20);
        }
        $data = array(
            'title' => 'Data Masakan',
            'masakans' => $masakans,
            'masakans' => $searched,
        );

        return view('admin.masakan.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
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
            'nama_masakan' => 'required',
            'harga' => 'required',
            'tipe' => 'required',
            'stok' => 'required',
            'status' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg,gif',
        ]);

        $input = $request->all();

        $masakan = Masakan::create($input);

        if ($masakan) {
            $fileupload = $request->file('image');
            $image = (new ImageController)->upload($fileupload, $masakan);
            if ($image) {
                return back()->with('success', 'Masakan berhasil ditambahkan!');
            } else {
                return back()->with('error', 'Something went wrong!');
            }
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Masakan $masakan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Masakan $masakan)
    {
        $data = array(
            'title' => 'Data Masakan',
            'masakan' => $masakan,
        );

        return view('admin.masakan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Masakan $masakan)
    {
        $this->validate($request, [
            'nama_masakan' => 'required',
            'harga' => 'required',
            'tipe' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();

        if ($masakan->update($input)) {
            if ($request->file('image')) {

                $this->validate($request, [
                    'image' => 'required|image|mimes:jpg,jpeg,png,svg,gif',
                ]);

                $fileupload = $request->file('image');
                $image = (new ImageController)->upload($fileupload, $masakan);

                if ($image) {
                    return redirect()->route('masakan.index')->with('success', 'Masakan berhasil diedit!');
                } else {
                    return redirect()->route('masakan.index')->with('error', 'Something went wrong!');
                }
            }
            
            return redirect()->route('masakan.index')->with('success', 'Masakan berhasil diedit!');
        } else {
            return redirect()->route('masakan.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masakan $masakan)
    {
        if ($masakan->delete()) {
            return back()->with('success', 'Masakan berhasil dihapus');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
