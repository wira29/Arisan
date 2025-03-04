@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{ $data->user->name ?? '-' }}</h5>
        </div>
        <div class="card-body">
            <p class="card-text">Status: </p>
            <!-- Anda bisa menambahkan lebih banyak konten di sini -->
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">

            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Gambar</th>
                        <th class="text-center">Nama Produk</th>
                        
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Total Harga</th>
                    </tr>
                </thead>
                <tbody>@foreach ($data->arisanUserProduks as $produk)</tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <th class="text-center">
                            <img src="{{ asset('images/produk/' . $produk->produk->gambar) }}" alt="{{ $produk->produk->nama }}" width="100">
                        </th>
                        <th class="text-center">{{ $produk->produk->nama }}</th>
                       
                        <th class="text-center">{{ $produk->qty }}</th>
                        <th class="text-center">{{ $produk->price }}</th>
                        <th class="text-center">{{ $produk->total_price }}</th>
                    </tr>
                    @endforeach
                </tfoot>
            </table>
        <div class="card-footer text-end">
            <a href="{{ route('approvedpeserta.index') }}" class="btn btn-dark">Kembali</a>
        </div>
    </div>
</div>
@endsection