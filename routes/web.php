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
    return view('/login');
});

// redirect halaman ketika halaman logout di akses halaman login
Route::redirect('/logout', '/login');

// page only for admin
Route::prefix('/admin')->group(function () {

    Route::get('/dashboard', function () {
        $page = array(
            "page" => "Dashboard",
            "description" => "Halaman yang berisi ringkasan aktivitas harian, seperti total penjualan, jumlah transaksi, produk terlaris, dan performa penjualan dalam periode tertentu."
        );
        return view('/dashboard')->with("page", $page);
    });

    Route::get('/pos', function () {
        $page = array(
            "page" => "Point of Sales",
            "description" => "Halaman inti untuk melakukan transaksi pembelian. Fitur utama termasuk pencarian produk, total pembelian, dan metode pembayaran. Halaman ini memungkinkan kasir untuk menyelesaikan transaksi dengan cepat dan efisien.",
        );

        return view('/pos')->with('page', $page);
    });

    Route::get('/inventory', function () {
        $page = array(
            "page" => "Inventory",
            "description" => "Halaman untuk mengelola stok produk. Admin dapat menambah, mengedit, atau menghapus produk, serta memantau jumlah stok secara real time.",
        );
        return view('/inventory')->with("page", $page);
    });

    Route::get('/transactions', function () {
        $page = array(
            "page" => "Transactions Management",
            "description" => "Halaman yang menyimpan semua riwayat transaksi yang pernah dilakukan. Kasir dan admin dapat mencari dan melihat detail setiap transaki, termasuk item yang dibeli, jumlah yang dibayar, metode pembayaran, dan waktu transaksi.",
        );
        return view('/transactions')->with("page", $page);
    });

    Route::get('/user', function () {
        $page = array(
            "page" => "User Management",
            "description" => "Halaman untuk mengelola akun pengguna sistem, seperti kasir dan admin.  Admin dapat menambah, mengedit, atau menghapus akun pengguna serta menetapkan hak akses user lain."
        );
        return view('/user')->with("page", $page);
    });

    Route::get('/settings', function () {
        $page = array(
            "page" => "Settings",
            "description" => "Halaman untuk mengatur preferensi sistem, seperti mata uang, pajak, default, metode pembyaran yag diterima, dan pengaturan lainnya yang mendukung operasiobal kasir.",
        );
        return view('/settings')->with("page", $page);
    });

    Route::get('/notifications', function () {
        $page = array(
            "page" => "Notifications",
            "description" => "Halaman untuk melihat notifikasi terbaru seperti stok produk yang menipurs, transaksi besar, atau perubahan penting pada sistem. Notifikasi ini membantu admin untuk selalu waspada terhadapa aktivitas yang memerlukan tindakan.",
        );
        return view('/notifications')->with("page", $page);
    });

    Route::get('/help', function () {
        $page = array(
            "page" => "Help and Support",
            "description" => "Halaman yang menyediakan panduan penggunaan sistem kasir, FAQ, dan cara menghubungi tim support jika pengguna mengalami masalah dengan sistem."
        );
        return view('/help')->with("page", $page);
    });

});

// halaman 404
Route::fallback(function () {
    return "404 Page not Found";
});