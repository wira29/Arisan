<?php

namespace Database\Seeders;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'nama_arisan' => 'Arisan',
            'deskripsi' => 'Arisan adalah sebuah aplikasi online untuk menjual produk dana yang bersifat gratis dan berbayar secara langsung melalui website.',
            'tanggal_mulai' => Carbon::now(),
            'tanggal_selesai' => Carbon::now()->addYears(1),
        ]);
    }
}
