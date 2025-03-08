<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArisanUser;
use Yajra\DataTables\DataTables;
use App\Models\ArisanUserProduk;

class ApprovedPesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = ArisanUser::with('user', 'arisanUserProduks.produk'); // Pastikan user dimuat

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user_name', function ($row) {
                return optional($row->user)->name ?? '-'; // Menghindari error jika user null
            })
            ->addColumn('action', function ($row) {
                $url = route('approvedpeserta.show', $row->id);
                $printUrl = route('approvedpeserta.print', $row->id); // Route untuk print
                return '
                    <a href="' . $url . '" class="btn btn-warning btn-sm mx-2">Detail</a>
                    <a href="' . $printUrl . '" target="_blank" class="btn btn-success btn-sm mx-2">Print</a>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('approvedpeserta.index');
}

public function print($id)
{
    // Ambil data peserta yang sudah di-approve
    $peserta = ArisanUser::with('user', 'arisanUserProduks.produk')
        ->where('id', $id)
        ->where('is_approved', 1) // Hanya peserta yang sudah di-approve
        ->first();

    // Jika peserta tidak ditemukan atau belum di-approve, redirect dengan pesan error
    if (!$peserta) {
        return redirect()->route('approvedpeserta.index')->with('error', 'Peserta belum di-approve atau tidak ditemukan.');
    }

    return view('approvedpeserta.print', compact('peserta'));
}





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = ArisanUser::with(['user', 'arisanUserProduks.produk'])->findOrFail($id); // Ambil data peserta beserta produk

        // Pastikan gambar ada pada produk
        if ($data->arisanUserProduks->isNotEmpty()) {
            foreach ($data->arisanUserProduks as $arisanProduk) {
                $produk = $arisanProduk->produk;
                // Cek jika produk memiliki gambar
                if ($produk && $produk->gambar) {
                    $produk->gambar_url = asset('images/produk/' . $produk->gambar); // Menambahkan URL gambar
                }
            }
        }

        return view('approvedpeserta.show', compact('data'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approve(Request $request, $id)
    {
        // Temukan peserta berdasarkan ID yang diberikan di request
        $data = ArisanUser::with('user', 'arisanUserProduks.produk')->find($id);

        // Periksa jika peserta tidak ditemukan
        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Peserta tidak ditemukan.']);
        }

        // Periksa jika peserta sudah disetujui
        if ($data->is_approved == 1) {
            return response()->json(['success' => false, 'message' => 'Peserta sudah disetujui sebelumnya.']);
        }

        // Ubah status is_approved menjadi 1
        $data->is_approved = 1;
        $data->save();

        // Kirimkan response berhasil
        return response()->json(['success' => true, 'message' => 'Peserta berhasil disetujui.', 'data' => $data]);
    }
}
