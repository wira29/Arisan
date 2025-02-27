@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <x-banner title="Pengaturan" description="Daftar Arisan."
        action="{{ route('setting.create') }}"></x-banner>

        <div class="card mt-3">
            <div class="card-body">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Nama Arisan</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Tanggal Mulai</th>
                            <th class="text-center">Tanggal Selesai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($setting as $settings)
                        <tr>
                            <td class="text-wrap">{{ $setting->nama_arisan }}</td>
                            <td class="text-wrap">{{ $setting->deskripsi }}</td>
                            <td class="text-wrap">{{ $setting->tanggal_mulai }}</td>
                            <td class="text-wrap">{{ $setting->tanggal_selesai }}</td>
                            
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
        @endsection
