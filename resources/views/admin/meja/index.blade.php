@extends('admin.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="admin-meja-index-main" id="main">
            
            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif

            <div class="card p-3 mb-3">
                <form action="{{ route('meja.store') }}" method="post">
                    @csrf
                    <h4>Tambah Meja</h4>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="nomor_meja" class="form-label">Nomor Meja</label>
                                <input type="text" name="nomor_meja" id="nomor_meja" class="form-control @error('nomor_meja') is-invalid @enderror" value="{{ old('nomor_meja') }}" required>
                                @error('nomor_meja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col pt-1">
                            <h6>Kapasitas Meja</h6>
                            <select name="kapasitas" id="kapasitas" class="form-select @error('kapasitas') is-invalid @enderror" required>
                                <option>Pilih kapasitas meja...</option>
                                <option value="2" {{ '2' == old('kapasitas') ? 'selected' : '' }}>2 Orang</option>
                                <option value="4" {{ '4' == old('kapasitas') ? 'selected' : '' }}>4 Orang</option>
                                <option value="6" {{ '6' == old('kapasitas') ? 'selected' : '' }}>6 Orang</option>
                            </select>
                            @error('kapasitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Tambah</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Nomor Meja</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mejas as $meja)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $meja->nomor_meja }}</td>
                                <td>{{ $meja->kapasitas }} Orang</td>
                                <td>{{ $meja->status }}</td>
                                <td>
                                    <div class="d-flex">
                                        @if ($meja->status != 'Tersedia')
                                            <a href="{{ route('meja.tersedia', $meja->id) }}" class="btn btn-primary me-2">Ubah Tersedia</a>
                                        @else
                                            <a href="{{ route('meja.terpakai', $meja->id) }}" class="btn btn-primary me-2">Ubah Terpakai</a>
                                        @endif
                                        <a href="{{ route('meja.edit', $meja->id) }}" class="btn btn-primary me-2">Edit</a>
                                        <form action="{{ route('meja.destroy', $meja->id) }}" method="post">
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
            {{ $mejas->links() }}
        </div>
    </div>
@endsection