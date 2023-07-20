<?php

use App\Http\Controllers\AdminWorkController;
use App\Http\Controllers\AjaxCuttingRequestController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CuttingProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeleteProdukImageController;
use App\Http\Controllers\DesignPointController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellingProductArsipController;
use App\Http\Controllers\SellingProdukController;
use App\Http\Controllers\UserDesignController;
use App\Http\Controllers\UsersDashboardController;
use App\Http\Controllers\UserViewProductController;
use App\Http\Controllers\VotingController;
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

Route::get('/dashboard', [DashboardController::class , 'admin_dashboard'])->middleware(['auth', 'verified', 'holding_D' , 'dashboard_admin'])->name('dashboard');
/* Route::get('/user_dashboard', [UsersDashboardController::class , 'user_dashboard'])->middleware(['auth', 'verified', 'holding_D' , 'dashboard_DC'])->name('user_dashboard'); */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* route untuk admin */
    Route::resource('/announcements' , AnnouncementController::class);
    Route::resource('/votings' , VotingController::class);
    Route::resource('/cutting_produks' , CuttingProdukController::class);

    /* route hapus produk_image */
    Route::put('/delete-image-produk/{slug_id}/{column_name}' , [DeleteProdukImageController::class , 'delete_image'])->name('delete_produk_image');

    /* route ajax permintaan data cutting_produks berdasarkan category_id yang dipilih */
    Route::get('/selected-cutting-size/{category_id}' , [AjaxCuttingRequestController::class , 'category_request'])->name('ajax.cat.request');
    Route::get('/update-cutting-size/{category_id}/{selling_id}' , [AjaxCuttingRequestController::class , 'update_category_request'])->name('ajax.update.cat.request');

    /* Route untuk akses admin only */
    Route::middleware('for_admin')->group(function() {
        Route::resource('/selling_produks' , SellingProdukController::class);
        Route::resource('/categories' , CategoryController::class);

         /* Route arsipkan product */
        Route::put('/arsip-product/{slug_id}/{status}' , [SellingProductArsipController::class , 'arsipkan'])->name('arsip_product');
        Route::get('/arsip-product' , [SellingProductArsipController::class , 'arsip_product'])->name('view_arsip');

        /* Route user design admin */
        Route::get('/all-design/{announcement}' , [UserDesignController::class , 'view_design'])->name('view.dsgn');
        Route::get('/all-vote-design/{announcement}' , [UserDesignController::class , 'view_vote_design'])->name('view.dsgn.vote');
        Route::get('/download-file/{design}' , [UserDesignController::class , 'download'])->name('download.dsgn');
        Route::delete('/design-del/{design}' , [UserDesignController::class , 'delete'])->name('deleted.dsgn');
        Route::put('/design-acc/{design}' , [UserDesignController::class , 'accept'])->name('acc.dsgn');

         /* Route admin pengelolaan pesanan dan penarikan point */
        Route::get('/admin-dipesan' ,[AdminWorkController::class , 'dipesan'])->name('dipesan.admin');
        Route::get('/admin-dikirim' ,[AdminWorkController::class , 'dikirim'])->name('dikirim.admin');
        Route::get('/admin-selesai' ,[AdminWorkController::class , 'selesai'])->name('selesai.admin');
        Route::get('/admin-penarikan-point' ,[AdminWorkController::class , 'bayar_point'])->name('payment.admin');
        
        Route::delete('/point-done/{user}' ,[AdminWorkController::class , 'point_cair'])->name('cair.point.admin');


        /* Route make diskon */
        Route::get('/create-diskon' , [DiskonController::class , 'create'])->name('create.diskon');
        Route::post('/create-diskon' , [DiskonController::class , 'store'])->name('store.diskon');
        Route::put('/tambah-produk-diskon' , [DiskonController::class , 'tambah_produk'])->name('tambah.prd.diskon');
        Route::get('/diskon-edit/{diskon}' , [DiskonController::class , 'edit'])->name('edit.diskon');
        Route::put('/update-diskon/{diskon}' , [DiskonController::class , 'update_diskon'])->name('updt.diskon');
        Route::put('/aktif-nonaktif-diskon/{diskon}' , [DiskonController::class , 'aktif_nonaktif'])->name('aktf.nonaktf.diskon');
        Route::delete('/delete-diskon/{diskon}' , [DiskonController::class , 'delete'])->name('delete.diskon');

        /* Route generate PDF */
        Route::get('/pdf-record/{tanggal_mulai}/{tanggal_selesai}' , [DashboardController::class , 'generate_pdf']);
       
    });

    Route::put('/kelola-produk/{order}' ,[AdminWorkController::class , 'update'])->name('updt.admin');

    Route::middleware('for_user')->group(function(){
        /* Route keranjang */
        Route::get('/user-keranjang' ,[KeranjangController::class , 'keranjang_user'])->name('user.keranjang');
        Route::get('/keranjang-confirmation' ,[KeranjangController::class , 'confirmation_keranjang'])->middleware('res_keranjang')->name('confirm.keranjang');
        Route::post('/user-keranjang' ,[KeranjangController::class , 'store'])->name('store.keranjang');
        Route::put('/update-keranjang/{keranjang}' ,[KeranjangController::class , 'update'])->name('updt.keranjang');
        Route::delete('/delete-keranjang/{keranjang}' ,[KeranjangController::class , 'delete'])->name('deleted.keranjang');
        Route::post('/use-keranjang-checkout' ,[KeranjangController::class , 'transaksi'])->name('transaksi.keranjang');
        Route::get('/checkouted-keranjang/{order}' ,[KeranjangController::class , 'checkout_keranjang'])->name('checkout.keranjang');

         /* Route user design */
        Route::post('/send-design' , [UserDesignController::class , 'store'])->name('send.dsgn');
        Route::put('/design-vote/{design}' , [UserDesignController::class , 'voted'])->name('voted.dsgn');
    });

  

    /* Route user view produk */
    Route::get('/user-product' ,[UserViewProductController::class , 'view_produk'])->middleware(['auth', 'verified', 'holding_D'])->name('view.prdk');
    Route::get('/show-product' ,[UserViewProductController::class , 'show_produk'])->middleware('res_order')->name('show.prdk');
    Route::post('/show-product-post' ,[UserViewProductController::class , 'transaksi'])->name('transaksi.prdk');
    Route::get('/information_order/{order}' ,[UserViewProductController::class , 'done_order'])->name('done.prdk');
    Route::get('/user-orders-view' ,[UserViewProductController::class , 'riwayat_order'])->name('user.orders.view');

    /* Route cair bonus */
    Route::post('/bonus-designer-cair' ,[DesignPointController::class , 'cair'])->name('cair.bonus');

});


require __DIR__.'/auth.php';
