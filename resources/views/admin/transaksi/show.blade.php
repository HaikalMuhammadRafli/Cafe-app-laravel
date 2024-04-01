@extends('admin.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="admin-transaksi-show-main" id="main">
            <div class="row">
                <div class="col">
                    <div class="card p-3">
                    <div class="row">
                        <div class="col">
                            <h4>{{ $transaksi->kode_transaksi }}</h4>
                        </div>
                        <div class="col">
                            @if ($transaksi->status == 'Completed')
                                <div class="btn btn-success float-end">{{ $transaksi->status }}</div>
                            @else
                                <div class="btn btn-secondary float-end">{{ $transaksi->status }}</div>
                            @endif
                        </div>
                    </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <div class="card p-3 mb-3">
                                    <p class="m-0"><strong>Nama Pelanggan :</strong> {{ $transaksi->user->nama_user }}</p>
                                    <p class="m-0"><strong>Tanggal :</strong> {{ Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}</p>
                                </div>
                                <button class="btn btn-primary w-100" onclick="window.print()">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-3">
                        <div class="row">
                            <div class="col">
                                <h4>{{ $order->kode_order }}</h4>
                            </div>
                            <div class="col">
                                @if ($order->status == 'Processing')
                                    <div class="btn btn-success float-end">{{ $order->status }}</div>
                                @else
                                    <div class="btn btn-secondary float-end">{{ $order->status }}</div>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="50px">No</th>
                                        <th>Masakan</th>
                                        <th>Keterangan</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->detail as $detail)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $detail->masakan->nama_masakan }}</td>
                                        <td>
                                            <pre>{{ $detail->keterangan }}</pre>
                                        </td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>Rp {{ number_format($detail->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h6>Harga Total</h6>
                            </div>
                            <div class="col">
                                <h6 class="float-end">Rp {{ number_format($order->total, 2) }}</h6>
                            </div>
                        </div>
                        <hr>
                        <h6>Keterangan :</h6>
                        <div class="card p-3 mb-3">
                            <pre>{{ $order->keterangan }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection