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
    <x-banner title="Riwayat Pembayaran" description="Riwayat Pembayaran Anda."></x-banner>

    <div class="card mt-3">
        <div class="card-body">
            <div class="col-md-12 table-responsive">
                @if ($user)
                <table class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Pembayaran-Ke</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody id="pembayaran-table">
                        <tr>
                            <td class="text-center" colspan="5">-- Tidak ada data --</td>
                        </tr>
                    </tbody>
                </table>
                @else 
                <p class="text-center">Akun anda belum diverifikasi oleh admin</p>
                @endif
            </div>
        </div>
    </div>
</div>        
@endsection

@push('js')
<script src="{{ asset('assets') }}/libs/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset('assets') }}/libs/select2/dist/js/select2.min.js"></script>

<script src="{{ asset('assets') }}/js/currency.js"></script>
<script src="{{ asset('assets') }}/js/date-helper.js"></script>

<script>
    $(document).ready(function() {

        let currentKe = 0;
        let currentUser = null;

        @if ($user)
            init();

            function init() {
            let tbody = '';
            let jumlah_bayar = parseInt("{{ $user->jumlah_bayar }}")

            $.ajax({
                url: "{{ '/riwayat' }}",
                method: 'GET',
                success: function(data) {
                    for (let i = 0; i < jumlah_bayar; i++) {
                        const is_paid = data.paid.includes(i + 1);
                        tbody += `<tr>
                                    <td>${is_paid ? `<s>minggu-${i + 1}</s>` : `minggu-${i + 1}`}</td>
                                    <td>${is_paid ? formatDate(data.pembayaran[i].created_at) : '-'}</td>
                                    <td>${is_paid ? formatCurrency(data.pembayaran[i].jumlah) : 'Rp. 0'}</td>
                                    <td>${is_paid ? data.pembayaran[i].metode : '-'}</td>
                                </tr>`;
                        
                    }

                    $('#pembayaran-table').html(tbody);
                },
                error: function(data) {
                    showToast('Gagal mendapatkan data!', 'error');
                }
            });
        }
        @endif
    });
</script>
@endpush