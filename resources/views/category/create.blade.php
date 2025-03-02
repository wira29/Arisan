@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets') }}/libs/dropzone/dist/min/dropzone.min.css">
@endpush
@push('js')
<script src="{{ asset('assets') }}/libs/dropzone/dist/min/dropzone.min.js"></script>
@endpush

@section('content')
<div class="container-fluid">
    <x-banner title="Tambah Kategori" description="Tambah kategori baru di situs web ini."></x-banner>
    <div class="card mt-3">
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="nama">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" placeholder="Nama Produk" value="{{ old('nama') }}">
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('category.index') }}" class="btn btn-dark">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection