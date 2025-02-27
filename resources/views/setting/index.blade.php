@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <x-banner title="Edit Arisan" description="Edit Arisan baru di situs web ini."></x-banner>
    <div class="card mt-3">
        <form action="{{ route('setting.update', $setting->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label class="mb-2" for="nama_arisan">Nama Arisan</label>
                            <input type="text" class="form-control @error('nama_arisan') is-invalid @enderror"
                                id="nama_arisan" name="nama_arisan"
                                value="{{ $setting->nama_arisan }}">
                            @error('nama_arisan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2" for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                id="deskripsi" name="deskripsi" value="{{ $setting->deskripsi }}">
                            @error('deskripsi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2" for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                id="tanggal_mulai" name="tanggal_mulai"
                                value="{{ $setting->tanggal_mulai }}">
                            @error('tanggal_mulai')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2" for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                id="tanggal_selesai" name="tanggal_selesai"
                                value="{{ $setting->tanggal_selesai }}">
                            @error('tanggal_selesai')
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