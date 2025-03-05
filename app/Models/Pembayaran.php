<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{

    protected $guarded = ['id'];

    public function arisanUser(): BelongsTo
    {
        return $this->belongsTo(ArisanUser::class);
    }
}
