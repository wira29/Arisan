<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(3),
            'harga_beli' => $hargaBeli = $this->faker->numberBetween(100, 100000),
            'harga_jual' => $this->faker->numberBetween($hargaBeli + 1, $hargaBeli + 50000),
            'gambar' => 'https://picsum.photos/seed/picsum/200',
        ];
    }
}
