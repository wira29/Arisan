@extends('layouts.app')

@section('content')

<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Form Tambah Pengaturan</h5>
                        <h6 class="card-subtitle text-muted">Anda dapat menambah Daftar Arisan di form ini</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Arisan</label>
                                <input type="text" name="nama_arisan" class="form-control" placeholder="Nama" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
                            </div>


                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary rounded-5">Submit</button>
                                <a class="btn btn-warning rounded-5" href="{{ route('setting.index') }}">Kembali</a>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection