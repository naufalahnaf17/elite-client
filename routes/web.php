<?php

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


Route::get('/' , 'AuthController@index');
Route::get('/login' , 'AuthController@login');
Route::get('/register' , 'AuthController@register');
Route::post('/login' , 'AuthController@login_store');
Route::post('/register' , 'AuthController@register_store');
Route::get('/logout' , 'AuthController@logout');

Route::get('data' , 'AuthController@json')->name('data');
Route::resource('siswa' , 'SiswaController');

//masuk session

Route::get('data-jenis', 'DataJenisController@index');
Route::get('data-jurusan', 'DataJurusanController@index');
Route::get('siswa' , 'SiswaController@index');
Route::get('tagihan' , 'TagihanController@index');
Route::get('pembayaran' , 'PembayaranController@index');
Route::get('laporan-tagihan' , 'LaporanTagihanController@index');
Route::get('laporan-pembayaran' , 'LaporanPembayaranController@index');
Route::get('laporan-saldo' , 'LaporanSaldoController@index');

//masuk session

// Ambil Data Profile
Route::get('my-profile' , 'AuthController@myprofile');
Route::post('update-profile/{id}' , 'AuthController@updateProfile');
