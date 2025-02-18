<?php

namespace Database\Seeders;

use Database\Factories\MahasiswaFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            RoleAndPermissionSeeder::class,
            MenuGroupSeeder::class,
            MenuItemSeeder::class,
            SosialSeeder::class,
            PendudukSeeder::class,
            OrganisasiSeeder::class,
            AgendaSeeder::class,
            PotensiSeeder::class,
            GaleriSeeder::class,
        ]);

        DB::statement("
            INSERT INTO kartu_keluarga (no_kk, alamat, rt, rw, kode_pos, kelurahan, kecamatan, kabupaten, provinsi)
            SELECT DISTINCT no_kk, alamat, rt, '5', '65147', 'Tanjungrejo', 'Sukun', 'Malang', 'Jawa Timur'
            FROM penduduk
        ");

        DB::statement("ALTER TABLE penduduk DROP COLUMN alamat, DROP COLUMN rt");
    }
}
