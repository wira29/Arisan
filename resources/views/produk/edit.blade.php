@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <x-banner title="Edit Arisan" description="Edit Arisan baru di situs web ini."></x-banner>
    <div class="card mt-3">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="nama">Nama Produk</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ $produk->nama }}">
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2" for="harga_beli">Harga Beli</label>
                            <input type="number" class="form-control @error('harga_beli') is-invalid @enderror"
                                id="harga_beli" name="harga_beli" value="{{ $produk->harga_beli }}">
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
                            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual"
                                name="harga_jual" value="{{ $produk->harga_jual }}">
                            @error('harga_jual')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                   <div class="col-md-6">
                    <div class="form-group">
                        <label class="mb-2" for="is_meubel">Jenis Produk</label>
                        <select name="is_meubel" class="form-control">
                            <option value="0" {{ old('is_meubel', $produk->is_meubel) == 0 ? 'selected' : '' }}>Bukan Mebel</option>
                            <option value="1" {{ old('is_meubel', $produk->is_meubel) == 1 ? 'selected' : '' }}>Mebel</option>
                        </select>
                    </div>
                </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2" for="is_tabungan">Jenis Produk</label>
                            <select name="is_tabungan" class="form-control">
                                <option value="0" {{ old('is_tabungan', $produk->is_tabungan) == 0 ? 'selected' : '' }}>Bukan Tabungan
                                </option>
                                <option value="1" {{ old('is_tabungan', $produk->is_tabungan) == 1 ? 'selected' : '' }}>Tabungan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2" for="category_id">Kategori</label>
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $produk->category_id) == $category->id ?
                                    'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                        

                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="gambar" class="form-label"><strong>Gambar:</strong></label>
                        <input accept="image/jpeg,png,jpg" type="file" id="gambar" name="gambar" class="form-control">
                        @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Current gambar"
                            style="max-width: 150px; height: auto; margin-top: 10px;">
                        @endif
                        @error('gambar')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection