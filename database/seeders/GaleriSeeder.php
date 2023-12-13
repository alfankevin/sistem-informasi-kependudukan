<?php

namespace Database\Seeders;

use App\Models\Galeri;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Galeri::create([
            'foto' => "PXL_21-08-2022_08-55-45-451.jpg"
        ]);
        Galeri::create([
            'foto' => "pengabdian.jpeg"
        ]);
        Galeri::create([
            'foto' => "PXL_20220821_083437480.jpg"
        ]);
        Galeri::create([
            'foto' => "DSC_0205.jpg"
        ]);
        Galeri::create([
            'foto' => "PXL_20220821_083518177.jpg"
        ]);
        Galeri::create([
            'foto' => "DSC_0253.jpg"
        ]);
        Galeri::create([
            'foto' => "DSC_0207.jpg"
        ]);
        Galeri::create([
            'foto' => "DSC_0256.jpg"
        ]);
    }
}
