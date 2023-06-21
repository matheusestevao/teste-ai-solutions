<?php

use App\Http\Controllers\ImportDocumentController;
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

Route::get('/', [ImportDocumentController::class, 'import_document'])->name('import_document');
Route::post('read_document', [ImportDocumentController::class, 'read_document'])->name('read_document');
Route::post('exec_job', [ImportDocumentController::class, 'exec_job'])->name('exec_job');