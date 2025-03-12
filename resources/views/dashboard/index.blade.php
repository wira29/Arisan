@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/style-card.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
@endpush



@push('js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
@endpush

@section('content')

<div class="container-fluid">

    <x-banner title="Dashboard" description="Linimasa Meubel Adji."></x-banner>

    <div class="row justify-content-center">
        <div class="col-md-6 justify-content-center align-items-center">
            <!-- Kartu pertama -->
            <a href="{{ route('produk.index') }}" class="data-card">
                <h3>{{ $produk->count() }}</h3>
                <h4>Total Produk</h4>
                <p>Total Produk yang tersedia di Arisan Meubel Adji</p>
                <span class="link-text">
                    Lihat semua produk
                    <svg width="15" height="8" viewBox="0 0 25 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.8631 0.929124L24.2271 7.29308C24.6176 7.68361 24.6176 8.31677 24.2271 8.7073L17.8631 15.0713C17.4726 15.4618 16.8394 15.4618 16.4489 15.0713C16.0584 14.6807 16.0584 14.0476 16.4489 13.657L21.1058 9.00019H0.47998V7.00019H21.1058L16.4489 2.34334C16.0584 1.95281 16.0584 1.31965 16.4489 0.929124C16.8394 0.538599 17.4726 0.538599 17.8631 0.929124Z"
                            fill="#753BBD" />
                    </svg>
                </span>
            </a>
        </div>

        <div class="col-md-6 align-items-center">
            <!-- Kartu kedua -->
            <a href="{{ route('approvedpeserta.index') }}" class="data-card">
                <h3>{{ $arisanUser->count() }}</h3>
                <h4>Total Peserta</h4>
                <p>Jumlah total peserta yang telah disetujui</p>
                <span class="link-text">
                    Detail Peserta
                    <svg width="25" height="16" viewBox="0 0 25 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.8631 0.929124L24.2271 7.29308C24.6176 7.68361 24.6176 8.31677 24.2271 8.7073L17.8631 15.0713C17.4726 15.4618 16.8394 15.4618 16.4489 15.0713C16.0584 14.6807 16.0584 14.0476 16.4489 13.657L21.1058 9.00019H0.47998V7.00019H21.1058L16.4489 2.34334C16.0584 1.95281 16.0584 1.31965 16.4489 0.929124C16.8394 0.538599 17.4726 0.538599 17.8631 0.929124Z"
                            fill="#753BBD" />
                    </svg>
                </span>
            </a>
        </div>
    </div>

    <!-- Tabel Total Price -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Total Arisan Meubel Adji</h4>
            <table id="pesertaTable" class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Peserta</th>
                        <th>Status Peserta</th>
                        <th>Total Semua Arisan (Rp)</th>
                        <th>Total Semua Tabungan (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($arisanUser as $index => $peserta)
                    @php 
                        $tabungan = App\Models\ArisanUserProduk::whereRelation('produk', function($q) {
                            return $q->where('is_tabungan', true);
                        })->where('arisan_user_id', $peserta->id)->sum('total_price');
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $peserta->user->name }}</td> <!-- Pastikan ada relasi ke user -->
                        <td>{{ $peserta->status }}</td>
                        <td>Rp {{ number_format($peserta->total_price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($tabungan, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>

                   <tr class="table-secondary">
                    <th colspan="3" class="text-end">Total Arisan:</th>
                    <th colspan="3" class="text-start">Rp {{ number_format($totalPrice, 0, ',', '.') }}</th>
                </tr>
                <tr class="table-secondary">
                    <th colspan="3" class="text-end">Total Tabungan:</th>
                    <th colspan="2" class="text-start">Rp {{ number_format($totalTabungan, 0, ',', '.') }}</th>
                </tr>

                <tr class="table-success">
                    <th colspan="3" class="text-end">Total Keseluruhan:</th>
                    <th colspan="3">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                </tr>

                    <tr class="table-success">
                            <th colspan="3" class="text-end">Total Arisan Individu:</th>
                            <th colspan="3">Rp {{ number_format($totalIndividu, 0, ',', '.') }}</th>
                        </tr>
                        
                        <tr class="table-success">
                            <th colspan="3" class="text-end">Total Arisan Grup:</th>
                            <th colspan="3">Rp {{ number_format($totalGrup, 0, ',', '.') }}</th>
                        </tr>

                  
                

                    
                    
                </tfoot>
            </table>
        </div>
    </div>

</div>

@push('js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function() {
        $('#pesertaTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 100]
        });
    });
</script>
@endpush

@endsection