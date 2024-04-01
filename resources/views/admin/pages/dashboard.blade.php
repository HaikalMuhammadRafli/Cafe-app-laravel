@extends('admin.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="admin-pages-dashboard-main" id="main">
            <div class="card p-3 mb-5">
                <div class="row">
                    <div class="col">
                        <div class="card p-3">
                            <h5>Pelanggan</h5>
                            <hr>
                            <h6>{{ $pelanggancount }}</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-3">
                            <h5>Meja</h5>
                            <hr>
                            <h6>{{ $mejacount }}</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-3">
                            <h5>Masakan</h5>
                            <hr>
                            <h6>{{ $masakancount }}</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card p-3">
                            <h5>Transaksi Pending</h5>
                            <hr>
                            <h6>{{ $transaksicount }}</h6>
                        </div>
                    </div>
                </div>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection