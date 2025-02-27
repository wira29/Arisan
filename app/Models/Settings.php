<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
       use HasFactory;

    protected $guarded = ['id'];
      protected $fillable = [
        'nama_arisan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
      ];
}
