@extends('kasir.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="kasir-pelanggan-edit-main" id="main">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif

            <div class="card p-3">
                <h4>Edit User</h4>
                <form action="{{ route('pelanggan-kasir.update', $user->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="nama_user" class="form-label">Nama User</label>
                                <input type="text" name="nama_user" id="nama_user" class="form-control @error('nama_user') is-invalid @enderror" value="{{ $user->nama_user }}" required>
                                @error('nama_user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col pt-1">
                            <h6>Email User</h6>
                            <div class="input-group">
                                <label for="email" class="input-group-text">@</label>
                                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="password" class="form-label">User New Password</label>
                                <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="password_cek" class="form-label">Confirm New Password</label>
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
                            <option value="{{ $level->id }}" {{ $level->id == $user->level_id ? 'selected' : '' }}>{{ $level->nama_level }}</option>
                        @endforeach
                    </select>
                    @error('id_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection