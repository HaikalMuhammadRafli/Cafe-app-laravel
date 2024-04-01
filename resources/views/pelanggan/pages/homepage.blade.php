@extends('pelanggan.layout.template')
@section('content')
    <div class="container-fluid">
        <div class="customer-pages-homepage-main" id="main">
            <h1>Welcome To<br>Kendedes Cafe!</h1>
            <p>Makan disini bakal menjadi kebiasaanmu!</p>
            <a href="{{ route('menu') }}" class="btn btn-primary">Pesan Sekarang!</a>
        </div>
    </div>
@endsection