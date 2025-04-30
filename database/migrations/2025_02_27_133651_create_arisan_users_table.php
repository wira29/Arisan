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
        Schema::create('arisan_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_finished')->default(false);
            $table->boolean('is_tabungan_diambil')->default(false);
            $table->enum('status', ['individu', 'grup'])->default('individu');
            $table->integer('tabungan')->default(0);
            $table->integer('total_arisan')->default(0);
            $table->integer('total_akhir')->default(0);
            $table->integer('jumlah_bayar')->default(45);
            $table->integer('bayar_per_minggu')->default(0);
            $table->integer('sudah_bayar')->default(0);
            $table->string('kode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arisan_users');
    }
};
