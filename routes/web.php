<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route::httpMethod('/path', [NamaController::class, 'namaFunc'])->name('identitas_route');
// httpMethod 
// get -> mengambil data/menampilkan halaman
// post -> mengirim data ke database (tambah data)
// patch/put -> mengubah data di database
// delete -> menghapus data
Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing_page');

// mengelola data obat
Route::get('/data-obat', [MedicineController::class, 'index'])->name('data_obat');

Route::prefix('/dashboard')->name('medicines.')->group(function(){
    Route::get('/halaman-tambah-obat', [MedicineController::class, 'create'])->name('create');
    Route::post('/create-obat', [MedicineController::class, 'store'])->name('store.obat');
    Route::get('/halaman-ubah-obat/{id}', [MedicineController::class, 'edit'])->name('edit');
    Route::patch('/update-obat/{id}', [MedicineController::class, 'update'])->name('update.obat');
});