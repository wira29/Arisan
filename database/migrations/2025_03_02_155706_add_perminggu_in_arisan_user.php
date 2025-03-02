<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('arisan_users', function (Blueprint $table) {
            $table->integer('jumlah_bayar')->default(0)->after('total_price');
            $table->integer('per_minggu')->default(0)->after('jumlah_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arisan_users', function (Blueprint $table) {
            //
        });
    }
};
