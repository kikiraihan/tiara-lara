<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\DatasetResource\CrudDataset;
use App\Livewire\CrudModel;
use App\Livewire\CrudUser;
use App\Livewire\CrudValidationModelDataset;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\DatasetResource\DatasetUploadForm;
use App\Livewire\KupvaNraResource\CrudKupvaNra;
use App\Livewire\KupvaProfilResource\CrudKupvaProfil;
use App\Livewire\Landing\Home;
use App\Livewire\Loby;
use App\Livewire\PjpNraResource\CrudPjpNra;
use App\Livewire\PjpProfilResource\CrudPjpProfil;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', Home::class)->name('landing.home');
Route::get('/home', Loby::class)->middleware(['auth', 'verified'])->name('crud.loby');

Route::get('/resource/user', CrudUser::class)->middleware(['auth', 'verified'])->name('crud.user');
Route::get('/resource/dataset', CrudDataset::class)->middleware(['auth', 'verified'])->name('crud.dataset');
Route::get('/resource/dataset/upload', DatasetUploadForm::class)->middleware(['auth', 'verified'])->name('crud.dataset.upload');
Route::get('/resource/model', CrudModel::class)->middleware(['auth', 'verified'])->name('crud.model');
// Route::get('/resource/validation-model-dataset', CrudValidationModelDataset::class)->middleware(['auth', 'verified'])->name('crud.validation-model-dataset');
Route::get('/resource/kupva-profil', CrudKupvaProfil::class)->middleware(['auth', 'verified'])->name('crud.kupva-profil');
Route::get('/resource/kupva-nra', CrudKupvaNra::class)->middleware(['auth', 'verified'])->name('crud.kupva-nra');
Route::get('/resource/pjp-profil', CrudPjpProfil::class)->middleware(['auth', 'verified'])->name('crud.pjp-profil');
Route::get('/resource/pjp-nra', CrudPjpNra::class)->middleware(['auth', 'verified'])->name('crud.pjp-nra');

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
