<?php

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

Route::get('/', function () {
    return view('welcome');
});

// Route halaman login
Route::get('/login', function () {
    return 'Ini Login';
});

// redirect halaman ketika halaman logout di akses halaman login
Route::redirect('/logout', '/login');

// page only for admin
Route::prefix('/admin')->group(function () {

    Route::get('/home', function () {
        return 'Ini Home';
    });

    Route::get('/program', function () {
        return 'Ini Program';
    });

    Route::get('/about', function () {
        return 'Ini About';
    });

    Route::get('/contactus', function () {
        return 'Ini Contact Us';
    });

    Route::get('/home/{name?}', function ($name = 'Jhonee') {
        return 'Ini ' . $name;
    });
});

// halaman 404
Route::fallback(function () {
    return "404 Page not Found";
});