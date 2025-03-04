<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArisanUser extends Model
{
    protected $guarded = ['id'];

    public function userProduks(): HasMany
    {
        return $this->hasMany(ArisanUserProduk::class);
    }

       public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'name');
    }

    public function arisanUserProduks()
{
    return $this->hasMany(ArisanUserProduk::class, 'arisan_user_id', 'id');
}

 public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id', 'id', 'nama');
    }
}
