<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ArisanUser extends Model
{
    protected $guarded = ['id'];

    public function userProduks(): HasMany
    {
        return $this->hasMany(ArisanUserProduk::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function scopeUnfinished($query)
    {
        return $query->where('is_finished', false);
    }

    public function scopeActive($query)
    {
        return $query->where('is_approved', true);
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
