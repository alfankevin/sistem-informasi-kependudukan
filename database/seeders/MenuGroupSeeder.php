<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use Illuminate\Database\Seeder;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuGroup::factory()->count(5)->create();
        MenuGroup::insert(
            [
                [
                    'name' => 'Dashboard',
                    'icon' => 'fas fa-tachometer-alt',
                    'permission_name' => 'dashboard',
                ],
                [
                    'name' => 'Kependudukan',
                    'icon' => 'fas fa-users',
                    'permisison_name' => 'penduduk.management',
                ],
                [
                    'name' => 'Organisasi',
                    'icon' => 'fas fa-sitemap',
                    'permisison_name' => 'organisasi.management',
                ],
                [
                    'name' => 'Bantuan Sosial',
                    'icon' => 'fas fa-handshake',
                    'permisison_name' => 'sosial.management',
                ],
                [
                    'name' => 'Agenda',
                    'icon' => 'fas fa-book',
                    'permisison_name' => 'agenda.management',
                ],
                [
                    'name' => 'Potensi',
                    'icon' => 'fas fa-store',
                    'permisison_name' => 'potensi.management',
                ],
                [
                    'name' => 'Galeri',
                    'icon' => 'fas fa-image',
                    'permisison_name' => 'galeri.management',
                ],
                [
                    'name' => 'Users Management',
                    'icon' => 'fas fa-user-tag',
                    'permission_name' => 'user.management',
                ],
                [
                    'name' => 'Role Management',
                    'icon' => 'fas fa-user-tag',
                    'permisison_name' => 'role.permission.management',
                ],
                [
                    'name' => 'Menu Management',
                    'icon' => 'fas fa-bars',
                    'permisison_name' => 'menu.management',
                ]
            ]
        );
    }
}
