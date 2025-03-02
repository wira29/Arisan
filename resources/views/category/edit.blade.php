@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <x-banner title="Edit Kategori" description="Edit Kategori baru di situs web ini."></x-banner>
    <div class="card mt-3">
        <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="nama">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ $category->nama }}">
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
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