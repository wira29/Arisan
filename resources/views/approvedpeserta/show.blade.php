@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-text">{{ $data->user->name ?? '-' }}</h5>
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
                <tbody>
                    @foreach ($data->arisanUserProduks as $produk)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <img src="{{ asset('storage/produk/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                                width="100">
                        </td>
                        <td class="text-center">{{ $produk->produk->nama }}</td>
                        <td class="text-center">{{ $produk->qty }}</td>
                        <td class="text-center">Rp {{ number_format($produk->price, 0, ',', '.') }}</td>
                        <td class="text-center">Rp {{ number_format($produk->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        <div class="card-footer text-end">
            <a href="{{ route('approvedpeserta.index') }}" class="btn btn-dark">Kembali</a>
        </div>
    </div>
</div>
@endsection