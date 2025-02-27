<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\ArisanUser;
use App\Models\Category;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $data = [
            'checkCurrentArisan' => ArisanUser::where('is_finished', false)->count(),
        ];
        return view('peserta.beranda.index', $data);
    }

    public function join()
    {
        $data = [
            'categories' => Category::with('produks')->get(),
        ];
        return view('peserta.beranda.join', $data);
    }
}
