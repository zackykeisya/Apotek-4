<?php

use App\Http\Controllers\KelolaAkunController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MedicineController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;

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
Route::middleware(['IsLogout'])->group(function() {
    

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [KelolaAkunController::class, 'loginProses'])->name('login.proses');

});


Route::middleware(['IsLogin'])->group(function() {
    Route::get('/logout', [KelolaAkunController::class, 'logout'])->name('logout');




// Route::httpMethod('/path', [NamaController::class, 'namaFunc'])->name('identitas_route');
// httpMethod 
// get -> mengambil data/menampilkan halaman
// post -> mengirim data ke database (tambah data)
// patch/put -> mengubah data di database
// delete -> menghapus data
Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing_page');

// Route::middleware(['IsAdmin'])->group(function)

// mengelola data obat
// Route::get('/data-obat', [MedicineController::class, 'index'])->name('data_obat');
Route::middleware(['IsAdmin'])->group(function() {
Route::prefix('/data_obat')->name('data_obat.')->group(function(){
    Route::get('/data', [MedicineController::class, 'index'])->name('data');
    Route::get('/tambah', [MedicineController::class, 'create'])->name('tambah');
    Route::post('/tambah/proses', [MedicineController::class, 'store'])->name('tambah.proses');
    Route::get('/ubah/{id}', [MedicineController::class, 'edit'])->name('ubah');
    Route::patch('/ubah/{id}/proses', [MedicineController::class, 'update'])->name('ubah.proses');
    Route::delete('/hapus{id}', [MedicineController::class, 'destroy'])->name('hapus');
    Route::patch('/ubah/stok/{id}', [MedicineController::class, 'updateStock'])->name('ubah.stok');
});

Route::get('/admin/orders', [OrderController::class, 'indexAdmin'])->name('admin.orders');
Route::get('/orders/export/excel', [OrderController::class, 'exportExcel'])->name('export.excel');

// Route::get('/kelola-akun')->name('kelola_akun.')->group(function() {
//     Route::get('/kelola', [])
// });
// });



Route::prefix('/kelola_akun')->name('kelola_akun.')->group(function(){
    Route::get('/akun',[KelolaAkunController::class, 'index'])->name('akun');
    Route::get('/tambah', [KelolaAkunController::class, 'create'])->name('tambah');
    Route::post('/tambah/proses', [KelolaAkunController::class, 'store'])->name('tambah.proses');
    Route::get('/ubah/{id}', [KelolaAkunController::class, 'edit'])->name('ubah');
    Route::patch('/ubah/{id}/proses', [KelolaAkunController::class, 'update'])->name('ubah.proses');
    Route::delete('/hapus{id}', [KelolaAkunController::class, 'destroy'])->name('hapus');
        });
    });

    Route::middleware('isKasir')->group(function(){
        Route::prefix('/kasir')->name('kasir.')->group(function() {
            Route::get('/order', [OrderController::class, 'index'])->name('order');
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/create/proses', [OrderController::class, 'store'])->name('create.proses');
            Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
            Route::get('/download/{id}', [OrderController::class, 'downloadPDF'])->name('download');
        });
    });

}); 