@extends('admin.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="admin-pages-laporan-index" id="main">
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-primary" onclick="window.print()">Print Laporan</button>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection