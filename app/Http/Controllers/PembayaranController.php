<?php

namespace App\Http\Controllers;

use App\Models\ArisanUser;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pembayaran = Pembayaran::where('arisan_user_id', $request->userId)
                ->get();

            return response()->json([
                'paid' => $pembayaran->pluck('pembayaran_ke'),
                'pembayaran' => $pembayaran,
            ]);
        }

        $data = [
            'users' => ArisanUser::with('user')->unfinished()->active()->get(),
        ];

        return view('pembayaran.index', $data);
    }

    public function bayar(Request $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                Pembayaran::create([
                    'arisan_user_id' => $request->arisan_user_id,
                    'pembayaran_ke' => $request->pembayaran_ke,
                    'jumlah' => $request->jumlah,
                    'metode' => $request->metode,
                ]);

                return [
                    'success' => true,
                    'message' => "Pembayaran berhasil dilakukan",
                ];
            });

            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => "Gagal melakukan pembayaran",
            ], 400);
        }
    }
}
