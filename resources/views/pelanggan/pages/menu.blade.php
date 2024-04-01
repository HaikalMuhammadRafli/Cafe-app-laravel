@extends('pelanggan.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="pelanggan-pages-menu-main" id="main">

            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            
            @if (isset($order))
                <div class="card p-3 mb-3">
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
                                    @if ($order->status == 'Pending')
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->detail as $detail)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>{{ $detail->masakan->nama_masakan }}</td>
                                    <td>
                                        <form action="{{ route('ket.detail', $detail->id) }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <textarea name="keterangan" id="" cols="2" rows="2" class="form-control">{{ $detail->keterangan }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ $detail->subtotal }}</td>
                                    @if ($order->status == 'Pending')
                                        <td>
                                            <form action="{{ route('detailorder.delete', $detail->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    @endif
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
                    <form action="{{ route('ket.order', $order->id) }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="keterangan" class="form-label">Tambahkan Keterangan</label>
                            <textarea name="keterangan" id="keterangan" cols="2" rows="2" class="form-control">{{ $order->keterangan }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary w-100">Simpan Keterangan</button>
                            <a href="{{ route('order.detail', $order->id) }}" class="btn btn-primary w-100 mx-2">Detail</a>
                            @if ($order->status == 'Pending')
                            <a href="{{ route('order.submit', $order->id) }}" class="btn btn-primary w-100">Teruskan Ke Kasir!</a>
                            @endif
                        </div>
                    </form>
                </div>
            @else
                <div class="card p-3 mb-3">
                    <form action="{{ route('buat.order') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-2 d-flex">
                                <h6 class="my-auto">Buat Order Sekarang!</h6>
                            </div>
                            <div class="col-md-8">
                                <select name="id_meja" id="id_meja" class="form-select" required>
                                    <option>Pilih meja...</option>
                                    @foreach ($mejas as $meja)
                                        <option value="{{ $meja->id }}">{{ $meja->nomor_meja }} - {{ $meja->kapasitas }} Orang</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Buat Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            <div class="card p-3 mb-3">
                <form action="{{ route('menu.masakan.filter') }}" method="get">
                    <h4>Filter</h4>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <h5>Tipe</h5>
                            <div class="card p-2">
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="tipe[Makanan]" id="tipe1" role="switch" value="Makanan" onChange="this.form.submit()" class="form-check-input" {{ request()->filled('tipe.Makanan') ? 'checked' : ''}}>
                                            <label for="tipe1" class="form-check-label">Makanan</label>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" name="tipe[Minuman]" id="tipe2" role="switch" value="Minuman" onChange="this.form.submit()" class="form-check-input" {{ request()->filled('tipe.Minuman') ? 'checked' : ''}}>
                                            <label for="tipe2" class="form-check-label">Minuman</label>
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

            <div class="row mb-4">
                @foreach ($masakans as $masakan)
                    @if ($masakan->tipe == 'Makanan')
                        <div class="col-md-3">
                            <div class="card rounded-3">
                                @if ($masakan->status == 'Tersedia')
                                    <img src="{{ \Storage::url($masakan->image->url) }}" alt="" class="img-fluid" style="border-radius: 8px 8px 0 0;">
                                @else
                                    <img src="{{ \Storage::url($masakan->image->url) }}" alt="" class="img-fluid grayscale-img" style="border-radius: 8px 8px 0 0;">
                                @endif
                                @if ($masakan->status == 'Tersedia')
                                    <div class="status-masakan">
                                        <p class="m-0">{{ $masakan->status }}</p>
                                    </div>
                                @else
                                    <div class="status-masakan" style="background-color: grey;">
                                        <p class="m-0">{{ $masakan->status }}</p>
                                    </div>
                                @endif
                                <div class="px-3 mt-3">
                                    <h6 class="m-0">Nama Makanan</h6>
                                    <p class="mb-1">{{ $masakan->nama_masakan }}</p>
                                    <h6 class="m-0">Harga</h6>
                                    <p class="mb-1">Rp {{ number_format($masakan->harga, 2) }}</p>
                                    <h6 class="m-0">Stok</h6>
                                    <p>{{ $masakan->stok }}</p>
                                </div>
                                @if ($masakan->status == 'Tersedia')
                                    @if (isset($order))
                                        <hr class="m-0 mb-2">
                                        <div class="p-3">
                                            <form action="{{ route('tambah.masakan', $masakan->id) }}" method="post">
                                                @csrf
                                                <div class="d-flex">
                                                    <div class="input-group me-2">
                                                        <label for="qty" class="input-group-text">qty</label>
                                                        <input type="number" name="qty" id="qty" class="form-control" value="1" required>
                                                    </div>
                                                    <input type="hidden" name="id_order" value="{{ $order->id }}">
                                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="row mb-4">
                @foreach ($masakans as $masakan)
                    @if ($masakan->tipe == 'Minuman')
                        <div class="col-md-3">
                            <div class="card rounded-3">
                                @if ($masakan->status == 'Tersedia')
                                    <img src="{{ \Storage::url($masakan->image->url) }}" alt="" class="img-fluid" style="border-radius: 8px 8px 0 0;">
                                @else
                                    <img src="{{ \Storage::url($masakan->image->url) }}" alt="" class="img-fluid grayscale-img" style="border-radius: 8px 8px 0 0;">
                                @endif
                                @if ($masakan->status == 'Tersedia')
                                    <div class="status-masakan">
                                        <p class="m-0">{{ $masakan->status }}</p>
                                    </div>
                                @else
                                    <div class="status-masakan" style="background-color: grey;">
                                        <p class="m-0">{{ $masakan->status }}</p>
                                    </div>
                                @endif
                                <div class="px-3 mt-3">
                                    <h6 class="m-0">Nama Minuman</h6>
                                    <p class="mb-1">{{ $masakan->nama_masakan }}</p>
                                    <h6 class="m-0">Harga</h6>
                                    <p>Rp {{ number_format($masakan->harga, 2) }}</p>
                                </div>
                                @if ($masakan->status == 'Tersedia')
                                    @if (isset($order))
                                        <hr class="m-0 mb-2">
                                        <div class="p-3">
                                            <form action="{{ route('tambah.masakan', $masakan->id) }}" method="post">
                                                @csrf
                                                <div class="d-flex">
                                                    <div class="input-group me-2">
                                                        <label for="qty" class="input-group-text">qty</label>
                                                        <input type="number" name="qty" id="qty" class="form-control" value="1" required>
                                                    </div>
                                                    <input type="hidden" name="id_order" value="{{ $order->id }}">
                                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection