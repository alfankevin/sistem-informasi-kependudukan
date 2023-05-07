<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penduduk>
 */
class PendudukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sosial_id' => $this->faker->randomDigit(),
            'kk_id' => $this->faker->randomDigit(),
            'nik' => $this->faker->randomNumber(9, true),
            'nama' => $this->faker->name(),
            'tempat_lahir' => $this->faker->state(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L','P']),           
            'golongan_darah' => $this->faker->randomElement(['A','B','AB','O']),
            'agama' => $this->faker->randomElement(['Islam','Kristen','Hindu','Budha','Konghucu']),
            'status_perkawinan' => $this->faker->randomElement(['Sudah Kawin','Belum Kawin']),
            'pekerjaan' => $this->faker->jobTitle(),
            'alamat' => $this->faker->address(),
            'keterangan' => $this->faker->randomElement(['Hidup','Meninggal']),
        ];
    }
}