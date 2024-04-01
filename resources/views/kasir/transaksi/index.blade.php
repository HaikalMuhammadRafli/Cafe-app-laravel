@extends('kasir.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="kasir-transaksi-index-main" id="main">
            
            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif

            <div class="card p-3 mb-3">
                <form action="{{ route('kasir.transaksi.filter') }}" method="get">
                    <h4>Filter</h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <h5>Status</h5>
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="status[Menunggu Pembayaran]" id="status1" role="switch" value="Menunggu Pembayaran" onChange="this.form.submit()" class="form-check-input" {{ request()->filled('status.Menunggu Pembayaran') ? 'checked' : ''}}>
                                            <label for="status1" class="form-check-label">Menunggu Pembayaran</label>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="status[Completed]" id="status2" role="switch" value="Completed" onChange="this.form.submit()" class="form-check-input" {{ request()->filled('status.Completed') ? 'checked' : ''}}>
                                            <label for="status2" class="form-check-label">Completed</label>
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
                            <th>Kode</th>
                            <th>Customer</th>
                            <th>Order</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $transaksi)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->user->nama_user }}</td>
                                <td>{{ $transaksi->order->kode_order }}</td>
                                <td>{{ Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}</td>
                                <td>Rp {{ number_format($transaksi->total, 2) }}</td>
                                <td>{{ $transaksi->status }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('transaksi-kasir.show', $transaksi->id) }}" class="btn btn-primary me-2">Details</a>
                                        @if ($transaksi->status == 'Menunggu Pembayaran')
                                            <a href="{{ route('kasir.transaksi.bayar', $transaksi->id) }}" class="btn btn-success me-2">Bayar</a>
                                            <form action="{{ route('transaksi-kasir.destroy', $transaksi->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Cancel</button>
                                            </form>
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