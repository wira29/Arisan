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