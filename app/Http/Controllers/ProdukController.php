<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Produk;
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
        return view('produk.create');
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
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdukRequest $request, string $id)
    {
           $validated = $request->validated();

          $produk = Produk::findOrFail($id);
          $produk->update($validated);

          return redirect()->route('produk.index')->with('succes', 'Produk berhasil diperbarui');
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
