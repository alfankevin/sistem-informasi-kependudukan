<?php

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\SosialController;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\PotensiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\Menu\MenuGroupController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\RoleAndPermission\RoleController;
use App\Http\Controllers\RoleAndPermission\ExportRoleController;
use App\Http\Controllers\RoleAndPermission\ImportRoleController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\RoleAndPermission\AssignPermissionController;
use App\Http\Controllers\RoleAndPermission\AssignUserToRoleController;
use App\Http\Controllers\RoleAndPermission\ExportPermissionController;
use App\Http\Controllers\RoleAndPermission\ImportPermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingPageController::class, 'index']);

Route::get('/agenda', function () {
    return view('main.page.agenda');
});

Route::get('/potensi', function () {
    return view('main.page.potensi');
});

Route::get('/galeri', function () {
    return view('main.page.galeri');
});

Route::get('/admin', function () {
    return view('admin.auth/login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/penduduk', [PendudukController::class, 'show'])->name('penduduk.show');
    Route::post('/import', [PendudukController::class, 'import'])->name('penduduk.import');
    Route::get('/export', [PendudukController::class, 'export'])->name('penduduk.export');

    //user list
    Route::prefix('user-management')->group(function () {
        Route::resource('user', UserController::class);
        Route::post('import', [UserController::class, 'import'])->name('user.import');
        Route::get('export', [UserController::class, 'export'])->name('user.export');
        Route::get('demo', DemoController::class)->name('user.demo');
    });

    Route::prefix('menu-management')->group(function () {
        Route::resource('menu-group', MenuGroupController::class);
        Route::resource('menu-item', MenuItemController::class);
    });

    Route::prefix('penduduk-management')->group(function () {
        //kependudukan
        Route::resource('penduduk', PendudukController::class)->except(['show']);
        Route::resource('keluarga', KeluargaController::class)->except(['show']);
        Route::resource('bantuan', BantuanController::class)->except(['show']);
    });

    Route::prefix('organisasi-management')->group(function () {
        //organisasi
        Route::resource('organisasi', OrganisasiController::class)->except(['show']);
    });

    Route::prefix('sosial-management')->group(function () {
        //sosial
        Route::resource('sosial', SosialController::class)->except(['show']);
    });

    Route::prefix('agenda-management')->group(function () {
        //agenda
        Route::resource('agenda', AgendaController::class)->except(['show']);
        Route::patch('/agenda/{id}/mark', [AgendaController::class, 'prioritas'])->name('agenda.mark');
    });

    Route::prefix('potensi-management')->group(function () {
        //potensi
        Route::resource('potensi', PotensiController::class)->except(['show']);
    });

    Route::prefix('galeri-management')->group(function () {
        //galeri
        Route::resource('galeri', GaleriController::class)->except(['show']);
    });

    Route::group(['prefix' => 'role-and-permission'], function () {
        //role
        Route::resource('role', RoleController::class);
        Route::get('role/export', ExportRoleController::class)->name('role.export');
        Route::post('role/import', ImportRoleController::class)->name('role.import');

        //permission
        Route::resource('permission', PermissionController::class);
        Route::get('permission/export', ExportPermissionController::class)->name('permission.export');
        Route::post('permission/import', ImportPermissionController::class)->name('permission.import');

        //assign permission
        Route::get('assign', [AssignPermissionController::class, 'index'])->name('assign.index');
        Route::get('assign/create', [AssignPermissionController::class, 'create'])->name('assign.create');
        Route::get('assign/{role}/edit', [AssignPermissionController::class, 'edit'])->name('assign.edit');
        Route::put('assign/{role}', [AssignPermissionController::class, 'update'])->name('assign.update');
        Route::post('assign', [AssignPermissionController::class, 'store'])->name('assign.store');

        //assign user to role
        Route::get('assign-user', [AssignUserToRoleController::class, 'index'])->name('assign.user.index');
        Route::get('assign-user/create', [AssignUserToRoleController::class, 'create'])->name('assign.user.create');
        Route::post('assign-user', [AssignUserToRoleController::class, 'store'])->name('assign.user.store');
        Route::get('assing-user/{user}/edit', [AssignUserToRoleController::class, 'edit'])->name('assign.user.edit');
        Route::put('assign-user/{user}', [AssignUserToRoleController::class, 'update'])->name('assign.user.update');
    });
});
