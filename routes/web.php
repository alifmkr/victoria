<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PosController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Controller;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // page only for admin
    // Route::prefix('/admin')->group(function () {

    Route::get('/dashboard', function () {
        $page = array(
            "page" => "Dashboard",
            "description" => "Halaman yang berisi ringkasan aktivitas harian, seperti total penjualan, jumlah transaksi, produk terlaris, dan performa penjualan dalam periode tertentu."
        );
        return view('welcome')->with("page", $page);
    });

    Route::get('/pos', [PosController::class, 'index']);
    // Menambah Produk ke keranjang
    // Route::post('/pos/add', [PosController::class, 'addToCart'])->name('pos.add');
    // Mengganti Produk di form
    // Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');

    // =============== PRODUCTS ==============================================
    // get All products
    Route::get('/products', [ProductController::class, 'index'])->name("products.index");
    // get 1 product
    Route::get('/products/{id}', [ProductController::class, 'getProduct'])->name("products.getById");
    // add 1 row data product
    Route::post('/products/add', [ProductController::class, 'store'])->name("products.add");
    Route::put('/products/update', [ProductController::class, 'update'])->name("products.update");
    Route::delete('/products/destroy/{id?}', [ProductController::class, 'destroy'])->name("products.destroy");

    // =============== CART ===================================================
    // get All Cart Items
    Route::get('/cartItems', [CartController::class, 'index'])->name("cart.index");
    // store data to cart
    Route::post('/cartItems/add', [CartController::class, 'store'])->name("cart.add");
    // delete 1 item in cart
    Route::delete('/cartItems/{id?}', [CartController::class, 'remove'])->name("cart.remove");

    // ============== Transaction ================================================
    // get All Transactions
    Route::get('/transactions', [TransactionController::class, 'index'])->name("transaction.index");
    // Store data transaction
    Route::post('/transactions/add', [TransactionController::class, 'store'])->name("transaction.add");
    // delete 1 transaction
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');
    // route to send email invoice
    Route::get("/transactions/invoice/{id}", [TransactionController::class, "downloadInvoice"])->name("transaction.invoice");


    // =========================INVENTORY ========================================
    Route::get('/inventory', [InventoryController::class, "index"]);

    // Route::get('/transactions', [TransactionController::class, "index"]);
    // Route::get('/transactions', [TransactionController::class, 'index'])->name("transaction.index");

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

    // });

});

// halaman 404
Route::fallback(function () {
    return "404 Page not Found";
});

require __DIR__ . '/auth.php';