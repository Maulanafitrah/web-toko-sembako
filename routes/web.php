<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN DEPAN & KATALOG
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome'); 
});

Route::get('/katalog', [ProductController::class, 'index'])->name('katalog');

Route::get('/produk/{id}', function ($id) {
    $product = DB::table('products')->where('id', $id)->first();
    if (!$product) abort(404);
    return view('produk_detail', compact('product'));
})->name('produk.detail');

/*
|--------------------------------------------------------------------------
| 2. SISTEM KERANJANG (CART)
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| 3. SISTEM PEMBAYARAN (QRIS & COD)
|--------------------------------------------------------------------------
*/
// Konfirmasi Manual & WhatsApp (Menggantikan Midtrans)
Route::post('/payment/manual', [PaymentController::class, 'prosesBayarManual'])->name('payment.manual');

/*
|--------------------------------------------------------------------------
| 4. AUTHENTICATION ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    if (session('admin_logged_in')) return redirect()->route('admin.dashboard');
    return view('login');
})->name('login');

Route::post('/login-proses', function (Request $request) {
    $admin = DB::table('admins')->where('username', $request->username)->first();
    
    if ($admin && password_verify($request->password, $admin->password)) {
        session(['admin_logged_in' => true]);
        return redirect()->route('admin.dashboard');
    }
    return back()->with('error', 'Username atau Password Salah!');
})->name('login.proses');

Route::get('/logout', function () {
    session()->forget('admin_logged_in');
    return redirect('/'); 
})->name('logout');

/*
|--------------------------------------------------------------------------
| 5. ADMIN PANEL (DASHBOARD, PESANAN & PRODUK)
|--------------------------------------------------------------------------
*/
// Grouping Admin dengan Middleware Session (Jika sudah ada) atau Prefix saja
Route::prefix('admin')->group(function () {
    
    // Dashboard Admin (Sekarang sudah termasuk Laporan Pendapatan)
    Route::get('/dashboard', [PaymentController::class, 'dashboard'])->name('admin.dashboard');
    
    // Manajemen Pesanan
    Route::post('/pesanan/setujui/{order_id}', [PaymentController::class, 'setujuiPesanan'])->name('admin.setujui');
    Route::delete('/pesanan/hapus/{order_id}', [PaymentController::class, 'hapusPesanan'])->name('admin.hapus');

    // Manajemen Produk
    Route::post('/produk/tambah', [PaymentController::class, 'tambahProduk'])->name('admin.produk.tambah');
    Route::put('/produk/update/{id}', [PaymentController::class, 'updateProduk'])->name('admin.produk.update');
    Route::delete('/produk/hapus/{id}', [PaymentController::class, 'hapusProduk'])->name('admin.produk.hapus');
});