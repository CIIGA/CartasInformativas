<?php

use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PregrabadaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [IndexController::class, 'index'])->name('index');
// Ruta de archivo para optener y consultar
Route::get('/plazas/{idPlaza}/imagen', [ArchivoController::class, 'index']);
Route::post('/guardar_archivos', [ArchivoController::class, 'store'])->name('guardar_archivos');
// Ruta de la obtencion de pregrabadas
Route::post('/pregrabadas', [PregrabadaController::class, 'store'])->name('pregrabadas');
Route::get('/pdfPregabadas/{idPlaza}/{plaza}/{fechaF}', [PregrabadaController::class, 'pdfPregabadas'])->name('pdfPregabadas');
Route::post('/GenerarPDFPregrabada', [PregrabadaController::class, 'GenerarPDFPregrabada'])->name('GenerarPDFPregrabada');
//Ruta de contact
Route::post('/contact', [ContactController::class, 'store'])->name('contact');
Route::get('/pdfContact/{idPlaza}/{plaza}/{fechaF}', [ContactController::class, 'pdfContact'])->name('pdfContact');
Route::post('/GenerarPDFContact', [ContactController::class, 'GenerarPDFContact'])->name('GenerarPDFContact');
//Ruta de correos
Route::post('/subirdatos', [CorreoController::class, 'store'])->name('subirdatos');
Route::get('/obtenerDatosTabla', [CorreoController::class, 'show'])->name('obtenerDatosTabla');
Route::get('/pdfCorreo/{idPlaza}/{fecha}', [CorreoController::class, 'pdfCorreo'])->name('pdfCorreo');
Route::post('/GenerarPDFCorreo', [CorreoController::class, 'GenerarPDFCorreo'])->name('GenerarPDFCorreo');
