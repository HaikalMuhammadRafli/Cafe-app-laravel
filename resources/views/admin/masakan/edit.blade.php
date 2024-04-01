@extends('admin.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="admin-masakan-edit-main" id="main">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif

            <div class="card p-3 mb-3">
                <h4>Edit Masakan</h4>
                <form action="{{ route('masakan.update', $masakan->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex justify-content-center mb-3 rounded-3" style="background-color: grey; height: 200px;">
                                <img src="{{ \Storage::url($masakan->image->url) }}" alt="" class="img-fluid rounded-3">
                            </div>
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
                                        <input type="text" name="nama_masakan" id="nama_masakan" class="form-control" value="{{ $masakan->nama_masakan }}" required>
                                        @error('nama_masakan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col pt-1">
                                    <h6>Harga Masakan</h6>
                                    <div class="input-group">
                                        <label for="harga" class="input-group-text">Rp</label>
                                        <input type="number" name="harga" id="harga" class="form-control" value="{{ $masakan->harga }}" required>
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
                                        <option value="Makanan" {{ 'Makanan' == $masakan->tipe ? 'selected' : '' }}>Makanan</option>
                                        <option value="Minuman" {{ 'Minuman' == $masakan->tipe ? 'selected' : '' }}>Minuman</option>
                                    </select>
                                    @error('tipe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <h6>Status Masakan</h6>
                                    <select name="status" id="status" class="form-select" required>
                                        <option>Pilih status masakan...</option>
                                        <option value="Tersedia" {{ 'Tersedia' == $masakan->status ? 'selected' : '' }}>Tersedia</option>
                                        <option value="Habis" {{ 'Habis' == $masakan->status ? 'selected' : '' }}>Habis</option>
                                        <option value="Coming-soon" {{ 'Coming-soon' == $masakan->status ? 'selected' : '' }}>Coming-soon</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-end">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection