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
    <x-banner title="Kategori" description="Daftar Kategori yang ada di situs web ini."
        action="{{ route('category.create') }}"></x-banner>
    <div class="card mt-3">
        <div class="card-body">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    @foreach ($categories as $category)
                        <tr>
                            <th class="text-center">{{ $loop->iteration }}</th>
                            <th class="text-center">{{ $category->nama }}</th>
                            <th class="text-center">
                                <a class="btn btn-primary" href="{{ route('category.edit', $category->id) }}">Edit</a>
                                <form id="delete-form" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                    <button type="button" class="btn btn-outline-danger delete-btn" data-id="{{ $category->id }}">
                                        Hapus
                                    </button>
                                </form> 
                            </th>
                        </tr>
                    @endforeach
                 
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

        // Menampilkan toast jika ada session success/error
        @if (session()->has('success'))
            showToast('{{ session('success') }}', 'success');
        @elseif (session()->has('error'))
            showToast('{{ session('error') }}', 'error');
        @endif

        // Delete modal menggunakan SweetAlert
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id'); // Ambil ID kategori dari tombol

            Swal.fire({
                title: 'Hapus Kategori',
                text: "Apakah anda yakin ingin menghapus kategori ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form delete dengan ID yang sesuai
                    var form = $('#delete-form');
                    form.attr('action', '{{ route('category.destroy', ':id') }}'.replace(':id', id));
                    form.submit();
                }
            });
        });

    });
</script>
@endpush