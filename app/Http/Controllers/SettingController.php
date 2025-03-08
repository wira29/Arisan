<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengaturanRequest;
use App\Models\ArisanUser;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $validated = $request->validated();
        // Settings::create($validated);
        // return to_route('setting.index')->with('success', 'Berhasil menambahkan arisan.');
        $setting = Setting::first(); // Find the product by ID
        return view('setting.index', compact('setting'))->with('succes', 'Berhasil mengubah arisan'); // Return to a view for editing the product
    }

    public function tutupArisan()
    {
        try {
            DB::transaction(function () {
                ArisanUser::where(['is_finished' => false])->update(['is_finished' => true, 'kode' => Str::random(10)]);
                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menutup arisan.",
                ]);
            });
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Gagal menutup arisan.",
            ], 400);
        }
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

        Setting::create($validated);
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
        $setting = Setting::first(); // Find the product by ID
        return view('setting.edit', compact('setting')); // Return to a view for editing the product
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengaturanRequest $request, string $id)
    {
        $validated = $request->validated();

        $setting = Setting::first();
        $setting->update($validated);

        return redirect()->route('setting.index')->with('succes', 'Arisan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
