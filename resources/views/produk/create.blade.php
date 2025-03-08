@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets') }}/libs/dropzone/dist/min/dropzone.min.css">
@endpush
@push('js')
<script src="{{ asset('assets') }}/libs/dropzone/dist/min/dropzone.min.js"></script>
@endpush

@section('content')
<div class="container-fluid">
    <x-banner title="Tambah Produk" description="Tambah produk baru di situs web ini." ></x-banner>
    <div class="card mt-3">
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="nama">Nama Produk</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama Produk" value="{{ old('nama') }}">
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="harga_beli">Harga Beli</label>
                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" placeholder="Harga Beli" value="{{ old('harga_beli') }}">
                            @error('harga_beli')
                                <span class="invalid-feedback" role="alert">    
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2" for="harga_jual">Harga Jual</label>
                            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" placeholder="Harga Jual" value="{{ old('harga_jual') }}">
                            @error('harga_jual')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="nama">Kategori</label>
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->nama }}
                                </option>
                                    
                                @endforeach
                            </select>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="is_meubel">Jenis Produk</label>
                            <select name="is_meubel" class="form-control">
                                <option value="0">Bukan Mebel</option>
                                <option value="1">Mebel</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2" for="gambar">Gambar Produk</label>
                            <input accept="image/jpeg,png,jpg" type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" placeholder="Gambar Produk" value="{{ old('gambar') }}" data-dz-name="{{ old('nama') }}">

                            @error('gambar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('produk.index') }}" class="btn btn-dark">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection