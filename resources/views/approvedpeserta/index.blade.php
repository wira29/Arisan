@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
@endpush

@push('js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
@endpush

@section('content')
<div class="container-fluid">
    <x-banner title="Peserta" description="Daftar peserta yang ada di situs web ini." action="{{ route('approvedpeserta.create') }}"></x-banner>
    <div class="card mt-3">
        <div class="card-body">
            <table id="example" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Approved</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Total harga</th>
                        <th class="text-center">Jumlah bayar</th>
                        <th class="text-center">Per minggu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Approved</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Total harga</th>
                        <th class="text-center">Jumlah bayar</th>
                        <th class="text-center">Per minggu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<x-delete-modal-component action="" />
@endsection

@push('js')
<script src="{{ asset('assets') }}/js/currency.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>
<script>
    $(document).ready(function() {

        @if (session()->has('success'))
            showToast('{{ session('success') }}', 'success');
        @elseif (session()->has('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
        
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('approvedpeserta.index') }}',
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false 
                },  
                {
                data: 'user.name', // Ubah dari 'user_id' ke 'user_name'
                render: function(data, type, row) {
                return `<td>${data}</td>`; // Menampilkan nama user
                }
                },
                {
                data: 'is_approved',
                render: function(data, type, row) {
                    console.log(data)
                return `<td><span class="badge ${data == 1 ? "bg-light-success text-success" : "bg-light-warning text-warning"}">${(data == 1 ? 'Disetujui' : 'Pending')}</span></td>`
                }
                },
                {
                data: 'status',
                render: function(data, type, row) {
                return `<td>${data}</td>`
                }
                },
                {
                data: 'total_price',
                render: function(data, type, row) {
                return `<td>${formatCurrency(data)}</td>`
                }
                },
                {
                data: 'jumlah_bayar',
                class: "text-center",
                render: function(data, type, row) {
                return `<td>${data}x</td>`
                }
                },
                {
                data: 'per_minggu',
                render: function(data, type, row) {
                return `<td>${formatCurrency(data)}</td>`
                }
                },
                // {
                // data: 'id',
                // render: function(data, type, row) {
                // let url = `{{ route('approvedpeserta.show', 0) }}`.replace('/0', '/' + row.id);
                // return `<a href="${url}" class="btn btn-warning btn-sm mx-2">Detail</a>`;
                // }
                // },
                {
                data: 'id',
                render: function(data, type, row) {
                // URL untuk halaman detail
                let url = `{{ route('approvedpeserta.show', 0) }}`.replace('/0', '/' + row.id);
                let printUrl = `{{ route('approvedpeserta.print', 0) }}`.replace('/0', '/' + row.id);
                
                
                // Tombol Detail dan Approved tanpa WhatsApp
                if (row.is_approved == 1) {
                    return `
                    <a href="${url}" class="btn btn-warning btn-sm mx-2">Detail</a>
                    <a href="${printUrl}" target="_blank" class="btn btn-success btn-sm mx-2">Print</a>`
                    
                }

                return `
                <a href="${url}" class="btn btn-warning btn-sm mx-2">Detail</a>
                <a href="javascript:void(0);" class="btn btn-success btn-sm mx-2 btn-approve" data-data='${JSON.stringify(row)}'>Approve</a>
                `;
                }
                }
            ],
        });
    });

    $(document).on('click', '.btn-approve',function() {
    const arisanUser = $(this).data('data');
        // Konfirmasi apakah user yakin untuk menyetujui dengan SweetAlert2
    Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Anda akan menyetujui peserta ini.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Setujui',
    cancelButtonText: 'Batal',
    reverseButtons: true
    }).then((result) => {
    if (result.isConfirmed) {
    // Lakukan AJAX request untuk mengubah status is_approved menjadi 1
    $.ajax({
    url: `{{ route('approve-peserta', ':id') }}`.replace(':id', arisanUser.id), // Pastikan rutenya sesuai
    method: 'POST',
    data: {
    _token: '{{ csrf_token() }}', // Kirimkan CSRF token
    id: arisanUser.id
    },
    success: function(response) {
    // Jika berhasil, tampilkan SweetAlert sukses
    if (response.success) {
        showToast(response.message, 'success');

        let products = 'Produk arisan anda:\n';
        console.log(response.data)
        response.data.arisan_user_produks.forEach(function(arisanProduk, index) {
            products += `${index + 1}. ${arisanProduk.produk.nama} (${formatCurrency(arisanProduk.produk.harga_jual)}) x ${arisanProduk.qty} = ${formatCurrency(arisanProduk.total_price)}\n`;
        });

        const jmlBayar = `Jumlah bayar: ${response.data.jumlah_bayar}x\n`;
        const perMinggu = `Per minggu: ${formatCurrency(response.data.per_minggu)}\n`;

        const message = encodeURIComponent(`${products + jmlBayar + perMinggu}anda telah disetujui bergabung arisan, anda sudah bisa login dengan akun anda`);
        const waUrl = `https://wa.me/+${arisanUser.user.phone_number}?text=${message}`;

        window.open(waUrl, "_blank"); // Membuka WhatsApp dalam tab baru

        window.location.reload()
    } else {
        showToast(response.message, 'error');
    }
    },
    error: function() {
        showToast(response.message, 'error');
    }
    });
    }
    });
    })
</script>
@endpush