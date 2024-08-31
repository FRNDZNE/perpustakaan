<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;


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
})->name('firstpage')->middleware('guest');

Route::get('/home', function(){
    if (Auth::user()->role->name == 'admin') {
        return redirect()->route('admin.dashboard');
    } else if (Auth::user()->role->name == 'siswa') {
        return redirect()->route('siswa.dashboard');
    }
})->middleware('auth');


Auth::routes([
    'register' => false,
]);

$roles = ['admin','siswa'];
foreach ($roles as $role) {
    Route::prefix($role)->middleware(['auth', "role:$role"])->group(function () use ($role) {
        // Route::get('/dashboard', [HomeController::class, '$role'])->name("$role.dashboard");
        Route::get('dashboard', function() use ($role){
            $controller = app(HomeController::class);
            $method = $role;
            return $controller->$method();
        })->name("$role.dashboard");
        Route::get('/profile',[ProfileController::class,'index'])->name("profile.$role");
        Route::post('/profile/update',[ProfileController::class,'update'])->name("update.$role");
    });
}

Route::prefix('admin')->middleware(['auth','role:admin'])->group(function(){
    // CRUD Kategori Buku
    Route::prefix('kategori')->group(function(){
        Route::get('/',[CategoryController::class,'index'])->name('index.kategori');
        Route::post('/store',[CategoryController::class,'store'])->name('store.kategori');
        Route::delete('/delete/{id}',[CategoryController::class,'delete'])->name('delete.kategori');
    });

    // CRUD Buku
    Route::prefix('buku')->group(function(){
        Route::get('/',[BookController::class,'index'])->name('index.buku');
        Route::get('/create',[BookController::class,'create'])->name('create.buku');
        Route::post('/store',[BookController::class,'store'])->name('store.buku');
        Route::get('/edit/{id}',[BookController::class,'edit'])->name('edit.buku');
        Route::post('/update/{id}',[BookController::class,'update'])->name('update.buku');
        Route::get('/detail/{id}',[BookController::class,'detail'])->name('detail.buku');
        Route::delete('/delete/{id}',[BookController::class,'delete'])->name('delete.buku');
    });

    // CRUD Siswa
    Route::prefix('siswa')->group(function(){
        Route::get('/',[SiswaController::class,'index'])->name('index.user');
        Route::get('/create',[SiswaController::class,'create'])->name('create.user');
        Route::post('/store',[SiswaController::class,'store'])->name('store.user');
        Route::get('/edit/{id}',[SiswaController::class,'edit'])->name('edit.user');
        Route::post('/update/{id}',[SiswaController::class,'update'])->name('update.user');
        Route::get('/detail/{id}',[SiswaController::class,'detail'])->name('detail.user');
        Route::delete('/delete/{id}',[SiswaController::class,'delete'])->name('delete.user');
        Route::post('/import',[SiswaController::class,'import'])->name('import.user');
    });
});

Route::prefix('siswa')->middleware(['auth','role:siswa'])->group(function(){
    // Peminjaman Buku
});
