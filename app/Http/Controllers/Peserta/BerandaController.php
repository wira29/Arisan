<?php

namespace App\Http\Controllers\Peserta;

use App\Helpers\CurrencyFormat;
use App\Http\Controllers\Controller;
use App\Models\ArisanUser;
use App\Models\ArisanUserProduk;
use App\Models\Category;
use App\Models\Produk;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        // Ambil ID pengguna yang sedang login
        $userId = auth()->id();

        // Ambil data pengguna yang sedang berpartisipasi dalam arisan dan produk yang diikuti
        $detailPesanan = ArisanUser::with(['user', 'arisanUserProduks.produk'])
            ->where('user_id', $userId)
            ->where('is_finished', false)
            ->first(); // Ambil satu arisan aktif

        // cek arisan 
        $setting = Setting::first();
        if (Carbon::now()->between(Carbon::make($setting->tanggal_mulai), Carbon::make($setting->tanggal_mulai)->addWeeks(3))) {
            $checkCurrentArisan = ArisanUser::where(['is_finished' => false, 'user_id' => $userId])->count();
        } else {
            $checkCurrentArisan = -1;
        }

        // dd($checkCurrentArisan);

        // Data yang dikirim ke tampilan
        $data = [
            'checkCurrentArisan' => $checkCurrentArisan,
            'detailPesanan' => $detailPesanan,
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
                    'status' => $request->status,
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
