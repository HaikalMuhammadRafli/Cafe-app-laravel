@extends('kasir.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="kasir-pelanggan-index-main" id="main">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif

            <div class="card p-3 mb-3">
                <h4>Registrasi User</h4>
                <form action="{{ route('pelanggan-kasir.store') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="nama_user" class="form-label">Nama User</label>
                                <input type="text" name="nama_user" id="nama_user" class="form-control @error('nama_user') is-invalid @enderror" value="{{ old('nama_user') }}" required>
                                @error('nama_user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col pt-1">
                            <h6>Email User</h6>
                            <div class="input-group">
                                <label for="email" class="input-group-text">@</label>
                                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="password" class="form-label">User Password</label>
                                <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="password_cek" class="form-label">Confirm Password</label>
                                <input type="text" name="password_cek" id="password_cek" class="form-control @error('password_cek') is-invalid @enderror" value="{{ old('password_cek') }}" required>
                                @error('password_cek')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h6>Level User</h6>
                    <select name="id_level" id="id_level" class="form-select mb-3 @error('id_level') is-invalid @enderror" required>
                        <option>Pilih user level...</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" {{ $level->id == old('id_level') ? 'selected' : '' }}>{{ $level->nama_level }}</option>
                        @endforeach
                    </select>
                    @error('id_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary float-end">Tambah</button>
                </form>
            </div>

            <div class="card p-3 mb-3">
                <form action="{{ route('kasir.pelanggan.search') }}" method="get">
                    <h4>Filter</h4>
                    <hr>
                    <h5>Search</h5>
                    <div class="d-flex">
                        <input type="text" name="key" id="key" class="form-control me-2" placeholder="Search">
                        <button type="submit" class="btn btn-outline-success">Search</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="50px">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $user->nama_user }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->level->nama_level }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('pelanggan-kasir.edit', $user->id) }}" class="btn btn-primary me-2">Edit</a>
                                        <form action="{{ route('pelanggan-kasir.destroy', $user->id) }}" method="post">
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
            {{ $users->links() }}
        </div>
    </div>
@endsection