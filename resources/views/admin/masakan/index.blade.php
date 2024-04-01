@extends('admin.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="admin-masakan-index-main" id="main">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif

            <div class="card p-3 mb-3">
                <h4>Tambah Masakan</h4>
                <form action="{{ route('masakan.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="w-100 img-fluid rounded-3 mb-3" style="background-color: grey; height: 200px;"></div>
                            <div class="input-group">
                                <input type="file" name="image" id="image" class="form-control">
                                <label for="image" class="input-group-text">Select</label>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5>Masakan Detail</h5>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="nama_masakan" class="form-label">Nama Masakan</label>
                                        <input type="text" name="nama_masakan" id="nama_masakan" class="form-control" value="{{ old('nama_masakan') }}" required>
                                        @error('nama_masakan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col pt-1">
                                    <h6>Harga Masakan</h6>
                                    <div class="input-group">
                                        <label for="harga" class="input-group-text">Rp</label>
                                        <input type="number" name="harga" id="harga" class="form-control" value="{{ old('harga') }}" required>
                                        <label for="harga" class="input-group-text">.00</label>
                                        @error('harga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <h6>Tipe Masakan</h6>
                                    <select name="tipe" id="tipe" class="form-select" required>
                                        <option>Pilih tipe masakan...</option>
                                        <option value="Makanan" {{ 'Makanan' == old('tipe') ? 'selected' : '' }}>Makanan</option>
                                        <option value="Minuman" {{ 'Minuman' == old('tipe') ? 'selected' : '' }}>Minuman</option>
                                    </select>
                                    @error('tipe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <h6>Stok Masakan</h6>
                                    <div class="input-group">
                                        <input type="number" name="stok" id="stok" class="form-control" value="{{ old('stok') }}" required>
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <h6>Status Masakan</h6>
                                    <select name="status" id="status" class="form-select" required>
                                        <option>Pilih status masakan...</option>
                                        <option value="Tersedia" {{ 'Tersedia' == old('status') ? 'selected' : '' }}>Tersedia</option>
                                        <option value="Habis" {{ 'Habis' == old('status') ? 'selected' : '' }}>Habis</option>
                                        <option value="Coming-soon" {{ 'Coming-soon' == old('status') ? 'selected' : '' }}>Coming-soon</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-end">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card p-3 mb-3">
                <form action="{{ route('masakan.filter') }}" method="get">
                    <h4>Filter</h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <h5>Tipe</h5>
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="tipe[Makanan]" id="tipe1" role="switch" value="Makanan" onChange="this.form.submit()" class="form-check-input" {{ request()->filled('tipe.Makanan') ? 'checked' : ''}}>
                                            <label for="tipe1" class="form-check-label">Makanan</label>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="tipe[Minuman]" id="tipe2" role="switch" value="Minuman" onChange="this.form.submit()" class="form-check-input" {{ request()->filled('tipe.Minuman') ? 'checked' : ''}}>
                                            <label for="tipe2" class="form-check-label">Minuman</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <h5>Search</h5>
                            <div class="d-flex">
                                <input type="text" name="key" id="key" class="form-control me-2" placeholder="Search">
                                <button type="submit" class="btn btn-outline-success">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Image</th>
                            <th>Nama Masakan</th>
                            <th>Harga</th>
                            <th>Tipe</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masakans as $masakan)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td><img src="{{ \Storage::url($masakan->image->url) }}" height="100px"></td>
                                <td>{{ $masakan->nama_masakan }}</td>
                                <td>{{ $masakan->harga }}</td>
                                <td>{{ $masakan->tipe }}</td>
                                <td>{{ $masakan->stok }}</td>
                                <td>{{ $masakan->status }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('masakan.edit', $masakan->id) }}" class="btn btn-primary me-2">Edit</a>
                                        <form action="{{ route('masakan.destroy', $masakan->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection