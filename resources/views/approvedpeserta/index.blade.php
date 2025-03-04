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
    <x-banner title="Persetujuan Peserta" description="Daftar produk yang ada di situs web ini."></x-banner>
    <div class="card mt-3">
        <div class="card-body">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Mebel</th>
                        <th class="text-center">Approved</th>
                        <th class="text-center">Selesai</th>
                        <th class="text-center">Tabungan</th>
                        <th class="text-center">Total harga</th>
                        <th class="text-center">Jumlah bayar</th>
                        <th class="text-center">Per minggu</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Mebel</th>
                        <th class="text-center">Approved</th>
                        <th class="text-center">Selesai</th>
                        <th class="text-center">Tabungan</th>
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
                data: 'user_name', // Ubah dari 'user_id' ke 'user_name'
                render: function(data, type, row) {
                return `<td>${data}</td>`; // Menampilkan nama user
                }
                },
                {
                data: 'is_mabel',
                render: function(data, type, row) {
                return `<td>${(data)}</td>`
                }
                },
                {
                data: 'is_approved',
                render: function(data, type, row) {
                return `<td>${(data)}</td>`
                }
                },
                {
                data: 'is_finished',
                render: function(data, type, row) {
                return `<td>${(data)}</td>`
                }
                },
                {
                data: 'tabungan',
                render: function(data, type, row) {
                return `<td>${formatCurrency(data)}</td>`
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
                render: function(data, type, row) {
                return `<td>${formatCurrency(data)}</td>`
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
                
                // URL WhatsApp untuk mengirim pesan (pastikan nomor yang ada benar)
                let phoneNumber = row.phone_number; // Misalkan phone_number ada dalam data row
                let whatsappUrl = `https://wa.me/${phoneNumber}?text=Hello,%20I%20approve%20this%20person%20for%20the%20arisan.`;
                
                // Tombol Detail dan Approved
                return `
                <a href="${url}" class="btn btn-warning btn-sm mx-2">Detail</a>
                <a href="${whatsappUrl}" class="btn btn-success btn-sm mx-2" onclick="approve(${row.id})">Approve</a>
                `;
                }
                }
            ],
        });
    });

        function approve(id) {
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
        url: `/admin/approvedpeserta/${id}/approve`, // Sesuaikan dengan route yang benar
        method: 'POST',
        data: {
        _token: '{{ csrf_token() }}', // Kirimkan CSRF token
        id: id
        },
        success: function(response) {
        // Jika berhasil, tampilkan SweetAlert sukses
        if (response.success) {
        Swal.fire(
        'Peserta Disetujui!',
        'Peserta telah berhasil disetujui.',
        'success'
        );
        // Update tampilan tombol atau status
        location.reload(); // Refresh halaman agar status terbaru terlihat
        } else {
        Swal.fire(
        'Gagal!',
        response.message,
        'error'
        );
        }
        },
        error: function() {
        Swal.fire(
        'Terjadi Kesalahan!',
        'Ada kesalahan dalam memproses permintaan Anda.',
        'error'
        );
        }
        });
        }
        });
        }
</script>
@endpush