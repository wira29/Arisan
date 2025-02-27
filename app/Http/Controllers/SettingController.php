<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengaturanRequest;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $setting = Settings::first(); // Find the product by ID
        return view('setting.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('setting.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengaturanRequest $request)
    {
        $validated = $request->validated();

        Settings::create($validated);
        return to_route('setting.index')->with('success', 'Berhasil menambahkan arisan.');
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
        $setting = Settings::first(); // Find the product by ID
        return view('setting.edit', compact('setting')); // Return to a view for editing the product
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validated = $request->validate([
        'nama_arisan'=> 'required|max:50',
        'deskripsi'=> 'required',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date',
         ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
