<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Produk;
use App\Models\Category;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as FacadesStorage;
use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Produk::query())->addIndexColumn()->make(true);
        }

        return view('produk.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ["categories"=>Category::all()];
        return view('produk.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdukRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('produk');
        } else {
            $validated['gambar'] = null;
        }

     $validated['is_tabungan'] = $request->has('is_tabungan') ? 1 : 0;
        // Set is_mebel menjadi 1 jika ada di request, jika tidak, set ke 0
    $validated['is_meubel'] = $request->has('is_meubel') ? 1 : 0;
    

        Produk::create($validated);
        return to_route('produk.index')->with('success', 'Berhasil menambahkan produk.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $data = ["categories"=>Category::all(), 'produk' => $produk];
        return view('produk.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdukRequest $request, Produk $produk)
    {
        $validated = $request->validated();

        if ($request->hasFile('gambar')) {
            if (FacadesStorage::exists($produk->gambar)) {
                FacadesStorage::delete($produk->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('produk');
        }

        $validated['is_tabungan'] = $request->input('is_tabungan', 0);

          // Set is_mebel menjadi 1 jika ada di request, jika tidak, set ke 0
     $validated['is_meubel'] = $request->input('is_meubel', 0);


        $produk->update($validated);

          return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        if (FacadesStorage::exists($produk->gambar)) {
            FacadesStorage::delete($produk->gambar);
        }
        $produk->delete();
        return to_route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
