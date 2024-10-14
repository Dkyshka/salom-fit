<?php

use App\Http\Controllers\Admin\Channels\JoinRequestAdminController;
use App\Http\Controllers\Admin\Chats\ChatsAdminController;
use App\Http\Controllers\Admin\PictureController;
use App\Http\Controllers\Admin\Plans\PlansAdminController;
use App\Http\Controllers\Admin\Products\ProductsAdminController;
use App\Http\Controllers\Admin\Setting\SettingAdminController;
use App\Http\Controllers\Admin\Users\UserAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Web\Payment\PaymentController;
use App\Http\Controllers\Web\TelegramDataController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return abort(404);
});

Route::prefix('admin')->group(function () {

    Route::middleware('guest:admin')->group(function() {
        Route::view('login', 'admin.login')->name('login');
        Route::post('auth', [UserAdminController::class, 'auth'])->name('admin_auth');
    });

    Route::middleware(['auth:admin'])->group(function() {


        Route::get('', [UserAdminController::class, 'index'])
            ->name('admin_index');

        Route::redirect('/', 'admin/users');

        // Users
        Route::get('users', [UserAdminController::class, 'index'])->name('users_admin');
        Route::get('users/add', [UserAdminController::class, 'create'])->name('users_create');
        Route::post('users/store', [UserAdminController::class, 'store'])->name('users_store');

        Route::get('users/edit/{user}', [UserAdminController::class, 'edit'])->name('users_edit');
        Route::post('users/update/{user}', [UserAdminController::class, 'update'])->name('users_update');
        Route::any('users/delete/{user}', [UserAdminController::class, 'destroy'])->name('users_delete');

        // Plans
        Route::get('plans', [PlansAdminController::class, 'index'])->name('plans_admin');
        Route::get('plans/add', [PlansAdminController::class, 'create'])->name('plans_create');
        Route::post('plans/store', [PlansAdminController::class, 'store'])->name('plans_store');

        Route::get('plans/edit/{plan}', [PlansAdminController::class, 'edit'])->name('plans_edit');
        Route::post('plans/update/{plan}', [PlansAdminController::class, 'update'])->name('plans_update');
        Route::any('plans/delete/{plan}', [PlansAdminController::class, 'destroy'])->name('plans_delete');

        // Products
        Route::get('products', [ProductsAdminController::class, 'index'])->name('products_admin');
        Route::get('products/add', [ProductsAdminController::class, 'create'])->name('products_create');
        Route::post('products/store', [ProductsAdminController::class, 'store'])->name('products_store');

        Route::get('products/edit/{product}', [ProductsAdminController::class, 'edit'])->name('products_edit');
        Route::post('products/update/{product}', [ProductsAdminController::class, 'update'])->name('products_update');
        Route::any('products/delete/{product}', [ProductsAdminController::class, 'destroy'])->name('products_delete');


        // Join request
        Route::get('requests', [JoinRequestAdminController::class, 'index'])->name('requests_admin');

        // Chats
        Route::get('channels/add', [ChatsAdminController::class, 'create'])->name('channels_create');
        Route::post('channels/store', [ChatsAdminController::class, 'store'])->name('channels_store');
        Route::get('channels', [ChatsAdminController::class, 'index'])->name('channels_admin');
        Route::get('channels/edit/{chat}', [ChatsAdminController::class, 'edit'])->name('channels_edit');
        Route::post('channels/update/{chat}', [ChatsAdminController::class, 'update'])->name('channels_update');
        Route::any('channels/delete/{chat}', [ChatsAdminController::class, 'destroy'])->name('channels_delete');

        // Settings
        Route::get('settings', [SettingAdminController::class, 'index'])->name('setting_admin');
        Route::post('settings/update/{setting?}', [SettingAdminController::class, 'update'])->name('setting_update');

        // Logout
        Route::get('logout', [UserAdminController::class, 'logout'])->name('admin_logout');

        // Pictures
        Route::post('pictures/store', [PictureController::class, 'store'])->name('pictures_store');
        Route::post('pictures/delete/{picture}', [PictureController::class, 'destroy'])->name('pictures_delete');
    });
});


Route::middleware('guest')->group(function() {
    // View
    Route::view('login', 'web.user.login')->name('login');
    Route::view('register', 'web.user.register')->name('register');

    Route::post('auth', [\App\Http\Controllers\Web\User\UserAuthController::class, 'auth'])
        ->name('auth');
    Route::post('auth/register', [\App\Http\Controllers\Web\User\UserAuthController::class, 'register'])
        ->name('auth_register');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/', function (\Illuminate\Http\Request $request) {
        return view('web.profile');
    })->name('cabinet');

    Route::get('tariffs', function () {
        $tariffs = \App\Models\Plan::all();

        return view('web.tariffs', compact('tariffs'));
    })->name('tariffs');

    Route::get('payment/{plan?}', [PaymentController::class, 'payment'])
        ->where('plan', '[0-9]')
        ->name('payment');

    Route::post('payment/store/{plan?}', [PaymentController::class, 'store'])
        ->where('plan', '[0-9]')
        ->name('payment_store');
});

//// Профиль
//Route::get('/', function (\Illuminate\Http\Request $request) {
//    return view('web.profile');
//})->name('cabinet');

//// Рефералы
//Route::get('referrals', function (\Illuminate\Http\Request $request) {
//    return view('web.referrals');
//})->name('referrals');

//Route::post('referrals/link', function(\Illuminate\Http\Request $request) {
//    $link = auth()->user()->getTelegramReferralLink();
//    return response()
//        ->json(['referral_link' => $link]);
//})->name('referrals_link');

// Проверяем Bot App
//Route::get('telegram', [TelegramDataController::class, 'index'])->name('telegram_index');
//Route::post('check', [TelegramDataController::class, 'telegramCheck'])->name('telegram_check');

Route::get('checkout/{id?}/{user_id?}', [OrderController::class, 'show'])->name('checkout.show');


