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
}
