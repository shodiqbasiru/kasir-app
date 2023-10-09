<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $price = $this->faker->numberBetween(1, 100) * 10000;
        $name = $this->faker->sentence(1, 3);
        $slug = Str::slug($name, '-') . $this->faker->unique()->numberBetween(1, 100);

        $kode_barang = "BRG-" . $this->faker->numberBetween(1, 100);
        $category_id = $this->faker->numberBetween(1, 4);
        return [
            'kode_barang' => $kode_barang,
            'nama_barang' => $name,
            'slug' => $slug,
            'category_id' => $category_id,
            'harga_barang' => $price,
            'stok_barang' => $this->faker->numberBetween(1, 100),
            'deskripsi_barang' => $this->faker->paragraph(1, 3),
        ];
    }
}
