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
        Schema::create('arisan_user_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arisan_user_id')->constrained();
            $table->foreignId('produks_id')->constrained();
            $table->integer('qty');
            $table->integer('price');
            $table->integer('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arisan_user_produks');
    }
};
