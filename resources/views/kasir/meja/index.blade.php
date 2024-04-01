@extends('kasir.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="kasir-meja-index-main" id="main">
            
            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif

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
                                <td>{{ $meja->kapasitas }}</td>
                                <td>{{ $meja->status }}</td>
                                <td>
                                    <div class="d-flex">
                                        @if ($meja->status != 'Tersedia')
                                            <a href="{{ route('kasir.meja.tersedia', $meja->id) }}" class="btn btn-primary me-2">Ubah Tersedia</a>
                                        @else
                                            <a href="{{ route('kasir.meja.terpakai', $meja->id) }}" class="btn btn-primary">Ubah Terpakai</a>
                                        @endif
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