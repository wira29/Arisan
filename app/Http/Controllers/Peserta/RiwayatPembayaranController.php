<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ArisanUser;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class RiwayatPembayaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pembayaran = Pembayaran::whereHas('arisanUser', function ($q) {
                return $q->where('user_id', auth()->id())->unfinished()->active();
            })->get();

            return response()->json([
                'paid' => $pembayaran->pluck('pembayaran_ke'),
                'pembayaran' => $pembayaran,
            ]);
        }

        $data = [
            'user' => ArisanUser::where('user_id', auth()->id())->unfinished()->active()->first(),
        ];

        return view('peserta.riwayat.index', $data);
    }
}
