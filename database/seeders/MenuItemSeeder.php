<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuItem::factory()->count(10)->create();
        MenuItem::insert(
            [
                [
                    'name' => 'Dashboard',
                    'route' => 'dashboard',
                    'permission_name' => 'dashboard',
                    'menu_group_id' => 1,
                ],
                [
                    'name' => 'Data Penduduk',
                    'route' => 'penduduk-management/penduduk',
                    'permission_name' => 'penduduk.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Data Kartu Keluarga',
                    'route' => 'penduduk-management/keluarga',
                    'permission_name' => 'keluarga.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Data Bantuan Sosial',
                    'route' => 'penduduk-management/bantuan',
                    'permission_name' => 'bantuan.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Organisasi Masyarakat',
                    'route' => 'organisasi-management/organisasi',
                    'permission_name' => 'organisasi.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'Bantuan Sosial',
                    'route' => 'sosial-management/sosial',
                    'permission_name' => 'sosial.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Agenda Sosial',
                    'route' => 'agenda-management/agenda',
                    'permission_name' => 'agenda.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'Potensi UMKM',
                    'route' => 'potensi-management/potensi',
                    'permission_name' => 'potensi.index',
                    'menu_group_id' => 6,
                ],
                [
                    'name' => 'Galeri Halaman',
                    'route' => 'galeri-management/galeri',
                    'permission_name' => 'galeri.index',
                    'menu_group_id' => 7,
                ],
                [
                    'name' => 'User List',
                    'route' => 'user-management/user',
                    'permission_name' => 'user.index',
                    'menu_group_id' => 8,
                ],
                // [
                //     'name' => 'Role List',
                //     'route' => 'role-and-permission/role',
                //     'permission_name' => 'role.index',
                //     'menu_group_id' => 9,
                // ],
                // [
                //     'name' => 'Permission List',
                //     'route' => 'role-and-permission/permission',
                //     'permission_name' => 'permission.index',
                //     'menu_group_id' => 9,
                // ],
                // [
                //     'name' => 'Permission To Role',
                //     'route' => 'role-and-permission/assign',
                //     'permission_name' => 'assign.index',
                //     'menu_group_id' => 9,
                // ],
                // [
                //     'name' => 'User To Role',
                //     'route' => 'role-and-permission/assign-user',
                //     'permission_name' => 'assign.user.index',
                //     'menu_group_id' => 9,
                // ],
                [
                    'name' => 'Menu Group',
                    'route' => 'menu-management/menu-group',
                    'permission_name' => 'menu-group.index',
                    'menu_group_id' => 9,
                ],
                [
                    'name' => 'Menu Item',
                    'route' => 'menu-management/menu-item',
                    'permission_name' => 'menu-item.index',
                    'menu_group_id' => 9,
                ],
            ]
        );
    }
}
