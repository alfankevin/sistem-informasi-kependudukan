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
            'nama' => $this->faker->name(),
            'tempat_lahir' => $this->faker->state(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L','P']),
            'golongan_darah' => $this->faker->randomElement(['A','B','AB','O','-']),
            'agama' => $this->faker->randomElement(['Islam','Katolik','Protestan','Hindu','Budha']),
            'status_perkawinan' => $this->faker->randomElement(['Kawin','Belum Kawin']),
            'status_keluarga' => $this->faker->randomElement(['0', '1']),
            'pekerjaan' => $this->faker->randomElement(['Dokter','Polisi','Pemadam Kebakaran','Pengacara','Desainer Grafis','Pilot','Guru','Teknisi','Layanan SEO','Admin']),
            'alamat' => $this->faker->address(),
            'rt' => $this->faker->randomElement(['1','2','3','4','5']),
            'keterangan' => $this->faker->randomElement(['Hidup','Meninggal']),
            'id_sosial' => $this->faker->randomElement(['1']),
        ];
    }
}
