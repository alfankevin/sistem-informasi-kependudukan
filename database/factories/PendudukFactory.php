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
            'no_kk' => $this->faker->nik(),
            'nik' => $this->faker->nik(),
            'kepala_keluarga' => $this->faker->randomElement(['0', '1']),
            'nama' => $this->faker->name(),
            'tempat_lahir' => $this->faker->state(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L','P']),           
            'golongan_darah' => $this->faker->randomElement(['A','B','AB','O']),
            'agama' => $this->faker->randomElement(['Islam','Katolik','Protestan','Hindu','Budha']),
            'status_perkawinan' => $this->faker->randomElement(['Sudah Kawin','Belum Kawin']),
            'pekerjaan' => $this->faker->jobTitle(),
            'alamat' => $this->faker->address(),
            'rt' => $this->faker->randomElement(['1','2','3','4','5']),
            'keterangan' => $this->faker->randomElement(['Hidup','Meninggal']),
            'sosial_id' => $this->faker->randomElement(['1','2']),
        ];
    }
}
