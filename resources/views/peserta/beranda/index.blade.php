@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Beranda</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-muted " href="index-2.html">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Beranda</li>
              </ol>
            </nav>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">  
              <img src="../../dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Menampilkan Produk yang Diikuti -->
  @if ($detailPesanan && $detailPesanan->arisanUserProduks->isNotEmpty())
  <div class="card mt-4">
    <div class="card-header bg-white text-dark d-flex align-items-center justify-content-between shadow-sm border-bottom">
      <div>
        <h5 class="mb-1">Arisan yang Diikuti</h5>
        <span class="fw-light" style="font-size: 0.9rem;">
          <strong class="text-warning">{{ auth()->user()->name }}</strong>
        </span>
      </div>
    </div>
    <div class="card-body">
      <ul class="list-group">
        @foreach ($detailPesanan->arisanUserProduks as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>{{ $item->produk->nama ?? 'Produk Tidak Ditemukan' }}</strong>
            <p class="mb-0 text-muted">
              Harga: Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}
              X  {{ $item->qty }} item
            </p>
          </div>
          @if ($item->produk->gambar)
          <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="Produk" class="img-fluid"
            style="width: 50px; height: 50px; object-fit: cover;">
          @endif
        </li>
        @endforeach
      </ul>
  
      <!-- Bagian Total Harga -->
      <div class="mt-3 p-3 bg-light rounded">
        <h6 class="mb-0 text-end">
          <strong>Total Harga Keseluruhan:</strong>
          <span class="text-success fw-bold">Rp {{ number_format($detailPesanan->total_price, 0, ',', '.') }}</span>
        </h6>
      </div>
  
    </div>
  </div>
  @else
  <div class="alert alert-warning mt-4">
    Anda belum mengikuti produk arisan.
  </div>
  @endif
    <div class="row">
        @if ($checkCurrentArisan == 0)
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100 bg-light-warning overflow-hidden shadow-none">
              <div class="card-body position-relative">
                <div class="row">
                  <div class="col-sm-7">
                    <div class="d-flex align-items-center mb-7">
                      <div class="rounded-circle overflow-hidden me-6">
                        <img src="{{ asset('assets') }}/images/profile/user-1.jpg" alt="" width="40" height="40">
                      </div>
                      <h5 class="fw-semibold mb-0 fs-5">Arisan Terbaru!</h5>
                    </div>
                    <div class="d-flex align-items-center">
                      <p>Silakan klik tombol dibawah ini untuk mengikuti arisan terbaru.</p>
                    </div>
                    <a href="{{ route('join') }}" class="btn btn-primary">Join Arisan</a>
                  </div>
                  <div class="col-sm-5">
                    <div class="welcome-bg-img mb-n7 text-end">
                      <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/welcome-bg.svg" alt="" class="img-fluid">
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        @endif
    </div>
  </div>    
@endsection