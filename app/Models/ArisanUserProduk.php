<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArisanUserProduk extends Model
{

    protected $guarded = ['id'];

    public function arisanUser()
{
    return $this->belongsTo(ArisanUser::class, 'arisan_user_id', 'id');
}

public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id');  // pastikan 'produk_id' adalah kolom yang benar
    }

}
