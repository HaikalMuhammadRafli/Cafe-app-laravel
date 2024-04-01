<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->level;
        $key = $request->query('key');

        if ($filter) {
            $users = User::orderBy('created_at', 'desc')
                            ->where('id_level', $filter)
                            ->where('id_level' , '!=', 3)
                            ->paginate(20);

            $searched = User::orderBy('created_at', 'desc')
                            ->where('id_level', $filter)
                            ->where('id_level' , '!=', 3)
                            ->where('nama_user', 'LIKE', '%' . $key . '%')
                            ->paginate(20);
        } else {
            $users = User::orderBy('created_at', 'desc')
                            ->where('id_level' , '!=', 3)
                            ->paginate(20);

            $searched = User::orderBy('created_at', 'desc')
                            ->where('id_level' , '!=', 3)
                            ->where('nama_user', 'LIKE', '%' . $key . '%')
                            ->paginate(20);
        }
        
        $levels = Level::orderBy('created_at', 'asc')
                        ->get();

        $data = array(
            'title' => 'Data User',
            'users' => $users,
            'users' => $searched,
            'levels' => $levels
        );

        return view('admin.pelanggan.index', $data)->with('no', ($request->input('page', 1) - 1) * 20);
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
            'nama_user' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_cek' => 'required',
            'id_level' => 'required',
        ]);

        if ($request->password != $request->password_cek) {
            return back()->with('error', 'Password tidak sama!')->withInput($request->all());
        }

        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);

        if ($user) {
            return back()->with('success', 'User berhasil ditambahkan!');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
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
        $user = User::findOrFail($id);
        $levels = Level::orderBy('created_at', 'asc')
                        ->get();

        $data = array(
            'title' => 'Edit User',
            'user' => $user,
            'levels' => $levels,
        );

        return view('admin.pelanggan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama_user' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_cek' => 'required',
            'id_level' => 'required',
        ]);

        if ($request->password != $request->password_cek) {
            return back()->with('error', 'Password tidak sama!')->withInput($request->all());
        }

        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $user = User::findOrFail($id);

        if ($user->update($input)) {
            return redirect()->route('pelanggan.index')->with('success', 'User berhasil diedit!');
        } else {
            return redirect()->route('pelanggan.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return back()->with('success', 'User berhasil dihapus');
        } else {
            return back()->with('error', 'Something went wrong!');
        }
    }
}
