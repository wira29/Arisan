@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <x-banner title="Edit Arisan" description="Edit Arisan baru di situs web ini."></x-banner>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
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
        
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="mb-2" for="deskripsi">Deskripsi</label>
                                    <textarea type="text" rows="3" class="form-control @error('deskripsi') is-invalid @enderror"
                                        id="deskripsi" name="deskripsi">{{ $setting->deskripsi }}</textarea>
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
        <div class="col-md-4">
            <div class="card w-100 bg-light-danger overflow-hidden shadow-none">
              <div class="card-body py-3">
                <div class="row justify-content-between align-items-center">
                  <div class="col-sm-12">
                    <h5 class="fw-semibold mb-9 fs-5">Tutup Arisan!</h5>
                    <p class="mb-9">
                      Menutup arisan akan menghilangkan semua data peserta dan data pembayaran. Arisan akan tereset ke periode selanjutnya.
                    </p>
                    <button class="btn btn-danger" id="tutup-arisan">Tutup Arisan</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>

    
</div>
@endsection

@push('js')
<script>
  $(document).ready(function () {
    $('#tutup-arisan').on('click', function() {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Ini akan menutup arisan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, tutup!',
        cancelButtonText: 'Tidak, batal!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('setting.tutupArisan') }}",
            method: 'POST',
            data: {
              _token: '{{ csrf_token() }}',
            },
            success: function(data) {
              showToast("Berhasil menutup arisan!", 'success');
              window.location.href = "/admin/setting";
            },
            error: function(data) {
              showToast("Gagal menutup arisan!", 'error');
              window.location.href = "/admin/setting";
            }
          });
        }
      });
    })
  });
</script>
@endpush