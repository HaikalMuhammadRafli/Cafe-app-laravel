@extends('admin.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="admin-meja-edit-main" id="main">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif

            <div class="card p-3 mb-3">
                <form action="{{ route('meja.update', $meja->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <h4>Edit Meja</h4>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="nomor_meja" class="form-label">Nomor Meja</label>
                                <input type="text" name="nomor_meja" id="nomor_meja" class="form-control @error('nomor_meja') is-invalid @enderror" value="{{ $meja->nomor_meja }}" required>
                                @error('nomor_meja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col pt-1">
                            <h6>Kapasitas Meja</h6>
                            <select name="kapasitas" id="kapasitas" class="form-select @error('kapasitas') is-invalid @enderror" required>
                                <option>Pilih kapasitas meja...</option>
                                <option value="2" {{ '2' == $meja->kapasitas ? 'selected' : '' }}>2 Orang</option>
                                <option value="4" {{ '4' == $meja->kapasitas ? 'selected' : '' }}>4 Orang</option>
                                <option value="6" {{ '6' == $meja->kapasitas ? 'selected' : '' }}>6 Orang</option>
                            </select>
                            @error('kapasitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection