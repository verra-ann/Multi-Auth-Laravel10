<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
//use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Admin;
use App\Models\Seller;

Route::get('/', function () {
    return view('admin.admin_login');
});

// Route::get('/clientList', function () {
//     return view('admin.clientList');
// });

//--------------------------------------------------ROUTE FOR ADMIN-----------------------------------------------------
Route::prefix('admin')->group(function (){

Route::get('/login', [AdminController::class,'Index'])->name('login_from');
Route::POST('/login/owner', [AdminController::class,'Login'])->name('admin.login');
Route::get('/clientList', [AdminController::class,'clientList'])->name('admin.clientList');
Route::get('/dashboard', [AdminController::class,'Dashboard'])->name('admin.dashboard')->middleware('AdminMiddleware');
Route::get('/logout', [AdminController::class,'AdminLogout'])->name('admin.logout')->middleware('AdminMiddleware');
Route::get('/register', [AdminController::class,'AdminRegister'])->name('admin.register');
Route::POST('/register/create', [AdminController::class,'AdminRegisterCreate'])->name('admin.register.create');
Route::POST('/user/create', [AdminController::class,'createNewUser'])->name('admin.newUser');
Route::get('/delete/{id}', [AdminController::class,'deleteClient'])->name('admin.deleteClient');
});
//----------------------------------------END ROUTE FOR ADMIN-------------------------------------------------------------

//-----------------------------------ROUTE FOR SELLER---------------------------------------------------------------------
Route::prefix('seller')->group(function (){

    Route::get('/login', [SellerController::class,'Index'])->name('seller_login_from');
    Route::POST('/login/owner', [SellerController::class,'SellerLogin'])->name('seller.login');
    Route::get('/dashboard', [SellerController::class,'SellerDashboard'])->name('seller.dashboard')->middleware('SellerMiddleware');
    Route::get('/logout', [SellerController::class,'SellerLogout'])->name('seller.logout')->middleware('SellerMiddleware');
    Route::get('/register', [SellerController::class,'SellerRegister'])->name('seller.register');
    Route::POST('/register/create', [SellerController::class,'SellerRegisterCreate'])->name('seller.register.create');
});
//-----------------------------------END ROUTE FOR SELLER-----------------------------------------------------------------


//-------------------ROUTE FOR CLIENT DASHBOARD------------------------------------------------
Route::get('/Client', function () {
    return view('ClientDashboard');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', function () {
      return view('AdminDashboard');
    })->name('AdminDashboard');
});

Route::post('NewClient', [UserController::class, 'NewClient']);
require __DIR__.'/auth.php';
