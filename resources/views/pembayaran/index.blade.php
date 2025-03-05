@extends('layouts.app')

@push('css')
<!-- --------------------------------------------------- -->
<!-- Select2 -->
<!-- --------------------------------------------------- -->
<link rel="stylesheet" href="{{ asset('assets') }}/libs/select2/dist/css/select2.min.css">
<!-- --------------------------------------------------- -->
@endpush

@section('content')
<div class="container-fluid">
    <x-banner title="Pembayaran" description="Daftar Pembayaran Peserta Arisan."></x-banner>

    <div class="card mt-3">
        <div class="card-body">
            <div class="col-md-12">
                <label for="exampleFormControlSelect1" class="mb-2">Pilih Peserta</label>
                <select class="form-control select2" id="peserta">
                    @foreach ($users as $user)
                        <option value="{{ json_encode($user) }}">{{ $user->user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="col-md-12">
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Pembayaran-Ke</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pembayaran-table">
                        
                        <tr>
                            <td>2</td>
                            <td>2020-01-02</td>
                            <td>Rp. 200.000</td>
                            <td>Belum Divalidasi</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>2020-01-03</td>
                            <td>Rp. 300.000</td>
                            <td>Belum Divalidasi</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>                                                                          
@endsection

@push('js')
<script src="{{ asset('assets') }}/libs/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('assets') }}/libs/select2/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // For select 2
        //***********************************//
        $(".select2").select2();

        init();
        function init() {
            let tbody = '';
            const user = JSON.parse($("#peserta").val());

            for (let i = 0; i < user.jumlah_bayar; i++) {
                tbody += `<tr>
                            <td>minggu-${i + 1}</td>
                            <td>-</td>
                            <td>Rp. 0</td>
                            <td>-</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Detail</a>
                                <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>`;
                
            }

            $('#pembayaran-table').html(tbody);
        }
    });
</script>
@endpush