<?php

namespace App\Helpers;

class CurrencyFormat
{
    public static function formatRupiah($angka, $prefix = 'Rp ')
    {
        return $prefix . number_format($angka, 0, ',', '.');
    }
}
