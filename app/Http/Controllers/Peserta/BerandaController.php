<?php

namespace App\Http\Controllers\Peserta;

use App\Helpers\CurrencyFormat;
use App\Http\Controllers\Controller;
use App\Models\ArisanUser;
use App\Models\ArisanUserProduk;
use App\Models\Category;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        $data = [
            'checkCurrentArisan' => ArisanUser::where(['is_finished' => false, 'user_id' => auth()->id()])->count(),
        ];
        return view('peserta.beranda.index', $data);
    }

    public function join()
    {
        $categories = Category::with('produks')->get();
        $data = [
            'categories' => $categories,
        ];
        return view('peserta.beranda.join', $data);
    }

    public function joinAction(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $arisanUser = ArisanUser::create([
                    'user_id' => auth()->id(),
                    'is_mabel' => $request->jumlahBayar,
                    'tabungan' => 0,
                    'is_approved' => false,
                    'is_finished' => false,
                    'total_price' => $request->totalBayar,
                    'jumlah_bayar' => $request->jumlahBayar,
                    'per_minggu' => $request->perMinggu,
                ]);

                foreach ($request->produks as $produk) {
                    ArisanUserProduk::create([
                        'arisan_user_id' => $arisanUser->id,
                        'produks_id' => $produk['produk']['id'],
                        'qty' => $produk['qty'],
                        'price' => $produk['produk']['harga_jual'],
                        'total_price' => $produk['total'],
                    ]);
                }
            });

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
