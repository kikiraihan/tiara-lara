<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\CrudUser;
use App\Livewire\DocumentResource\PageDocumentList;
use App\Livewire\DocumentResource\PageDocumentUploadForm;
use App\Livewire\KnowledgeList;
use App\Livewire\Landing\Home;
use App\Livewire\Loby;
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
Route::get('/resource/documents', PageDocumentList::class)->middleware(['auth', 'verified'])->name('crud.document');
Route::get('/resource/documents/upload', PageDocumentUploadForm::class)->middleware(['auth', 'verified'])->name('crud.document.upload');
Route::get('/knowledges', KnowledgeList::class)->middleware(['auth', 'verified'])->name('crud.knowledge');
Route::get('/resource/user', CrudUser::class)->middleware(['auth', 'verified'])->name('crud.user');



// Route::get('/dashboard', function () {
  //     return view('dashboard');
  // })->middleware(['auth', 'verified'])->name('dashboard');
  
// BAWAAN LARAVEL
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
