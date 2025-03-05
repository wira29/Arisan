<?php

namespace App\Http\Controllers;

use App\Models\ArisanUser;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $data = [
            'users' => ArisanUser::with('user')->unfinished()->active()->get(),
        ];

        return view('pembayaran.index', $data);
    }
}
