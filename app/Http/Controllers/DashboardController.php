<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\ArisanUser;
use App\Models\ArisanUserProduk;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::all();
        $arisanUser = ArisanUser::with('arisanUserProduks')
            ->active()
            ->unfinished()
            ->get();

        $totalTabungan = ArisanUserProduk::whereRelation('arisanUser', function ($q) {
            return $q->active()->unfinished();
        })->whereRelation('produk', function ($q) {
            return $q->where('is_tabungan', true);
        })->sum('total_price');

        $totalPrice = $arisanUser->sum('total_price'); // Total semua total_price
        $grandTotal = $totalPrice + $totalTabungan; // Total keseluruhan

        return view('dashboard.index', compact('produk', 'arisanUser', 'totalPrice', 'totalTabungan', 'grandTotal'));
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
    public function show(string $id)
    {
        //
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
}
