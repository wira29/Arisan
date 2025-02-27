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
    <x-banner title="Produk" description="Daftar produk yang ada di situs web ini." action="{{ route('produk.create') }}"></x-banner>
    <div class="card mt-3">
        <div class="card-body">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Harga Beli</th>
                        <th class="text-center">Harga Jual</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Harga Beli</th>
                        <th class="text-center">Harga Jual</th>
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
<script>
    $(document).ready(function() {

        @if (session()->has('success'))
            showToast('{{ session('success') }}', 'success');
        @elseif (session()->has('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
        

        // delete modal 
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Produk',
                text: "Apakah anda yakin ingin menghapus produk ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(document).find('#delete-modal').attr('action', '{{ route('produk.destroy', ':id') }}'.replace(':id', id)).submit();
                }
            })
        });

        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('produk.index') }}',
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false 
                },  
                { 
                    data: 'nama', 
                    render: function(data, type, row) {
                        return `<td class='text-center'>
                                <img src="{{ asset('storage/'.':gambar') }}" width="48" height="48"/>
                                ${data}
                            </td>`.replace(':gambar', row.gambar)
                    } 
                },
                { data: 'harga_beli', 
                className: 'text-center',
                render: function(data, type, row) {
                        return `<td>${formatCurrency(data)}</td>`
                    } },
                { data: 'harga_jual', 
                className: 'text-center',
                render: function(data, type, row) {
                        return `<td>${formatCurrency(data)}</td>`
                    } },
                { data: 'id', render: function(data, type, row) {
                    return `<a href="#" class="btn btn-warning btn-sm mx-2">Edit</a><a href="#" class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Hapus</a>`;
                } },
            ],
        });
    });
</script>
@endpush