<?php

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

//rota para o home
Route::get('/', function () {
    return view('home_page');
})->name('home');


//rota post do forms
Route::post('/encurl', 'Main@encurl')->name('encurl');

//rota de redirecionamento
Route::get('/SB{ID}', 'Main@redirectUrl');
