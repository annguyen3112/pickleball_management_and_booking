<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankInformationController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FootballPitchController;
use App\Http\Controllers\FootballPitchDetailController;
use App\Http\Controllers\IdentityPaperController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PitchTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerController;
use App\Models\Equipment;
use App\Models\BankInformation;
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
//client
Route::controller(ClientController::class)->group(function () {
    Route::name('client.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('san-bong/{id}', 'footballPitchDetail')->name('footballPitchDetail');
        Route::get('checkout/{id}', 'checkout')->name('checkout');
        Route::get('findOderByCode', 'findOrderByCode')->name('findOrderByCode');
        Route::get('/order', [OrderController::class, 'showOrderForm']);
        // Route::get('success/{id}', [OrderController::class, 'success'])->name('order.success');
        // Route::put('cancel/{id}', [OrderController::class, 'cancel'])->name('order.cancel');
        Route::get('/guest/success/{id}', [OrderController::class, 'guestSuccess'])->name('guest.success');
        Route::put('/guest/cancel/{id}', [OrderController::class, 'guestCancel'])->name('guest.cancel');
    });
});
Route::middleware('client')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('logout', 'processClientLogout')->name('client.logout');
    });
    Route::controller(ClientController::class)->group(function () {
        Route::get('profile', 'profile')->name('client.profile');
        Route::get('order-by-me', 'orderByMe')->name('client.orderByMe');
    });
    Route::controller(UserController::class)->group(function () {
        Route::put('update/{id}', 'update')->name('user.update');
        Route::put('changePassword/{id}', 'changePassword')->name('user.changePassword');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::put('cancelOrder/{id}', 'cancelOrder')->name('order.cancelOrder');
        Route::put('cancel/{id}', 'cancel')->name('order.cancel');
        Route::get('success/{id}', 'success')->name('order.success');
    });
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');
    Route::get('/order', [OrderController::class, 'showOrderForm']);
    
});
Route::middleware('not_client')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        // Route::get('auth/redirect/{provider_name}', 'socialLogin')->name('client.socialLogin');
        // Route::get('auth/callback/{provider_name}', 'socialCallback')->name('client.socialCallback');
        Route::get('login', 'clientLogin')->name('client.login');
        Route::post('login', 'processClientLogin')->name('client.processLogin');
        Route::get('register', 'clientRegister')->name('client.register');
        Route::post('register', 'processClientRegister')->name('client.processRegister');
    });
});
//admin
Route::middleware('admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::name('admin.')->group(function () {
            Route::controller(AdminController::class)->group(function () {
                Route::get('/', 'dashboard')->name('dashboard');
                Route::get('pitchType', 'pitchType')->name('pitchType');
                Route::get('footballPitch', 'footballPitch')->name('footballPitch');
                Route::get('footballPitchDetail/{id}', 'footballPitchDetail')->name('footballPitchDetail');
                Route::get('equipment', 'equipment')->name('equipment');
                Route::get('order-calendar', 'orderCalendar')->name('orderCalendar');
                Route::get('order-table', 'orderTable')->name('orderTable');
                Route::get('checkout-order/{id?}', 'checkout')->name('checkout');
                Route::get('bank-information', 'bankInformation')->name('bankInformation');
                Route::get('employe', 'employe')->name('employe');
                Route::get('customer', 'customer')->name('customer');
                Route::get('owner', 'owner')->name('owner');
            });

            Route::controller(AuthController::class)->group(function () {
                Route::get('logout', 'processAdminLogout')->name('logout');
            });
        });
        Route::name('pitchType.')->group(function () {
            Route::controller(PitchTypeController::class)->group(function () {
                Route::post('pitch_type', 'store')->name('store');
                Route::put('pitch_type/{id}', 'update')->name('update');
                Route::delete('pitch_type/{id}', 'destroy')->name('destroy');
                Route::get('pitch_type/{id}', 'show')->name('show');
            });
        });
        Route::name('footballPitch.')->group(function () {
            Route::controller(FootballPitchController::class)->group(function () {
                Route::post('footballPitch', 'store')->name('store');
                Route::put('footballPitch/{id}', 'update')->name('update');
                Route::get('footballPitch/{id}', 'show')->name('show');
            });
        });
        Route::name('footballPitchDetail.')->group(function () {
            Route::controller(FootballPitchDetailController::class)->group(function () {
                Route::post('footballPitchDetail', 'store')->name('store');
                Route::delete('footballPitchDetail/{id}', 'destroy')->name('destroy');
            });
        });
        Route::name('order.')->group(function () {
            Route::controller(OrderController::class)->group(function () {
                Route::delete('clearOrderNotUse', 'clearOrderNotUse')->name('clearOrderNotUse');
            });
        });
        
    });
});
Route::middleware('not_admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('login', 'adminLogin')->name('admin.login');
            Route::post('login', 'processAdminLogin')->name('admin.processLogin');
        });
    });
});

//api
Route::prefix('api')->group(function () {
    Route::controller(FootballPitchController::class)->group(function () {
        Route::get('footballPitch', 'index')->name('footballPitch.index');
        Route::put('footballPitchMaintenance/{id}', 'maintenance')->name('footballPitch.maintenance');
        Route::delete('footballPitch/{id}', 'destroy')->name('destroy');
    });
    Route::get('fetchEquipment', [EquipmentController::class, 'fetchEquipment'])->name('equipment.fetchEquipment');

    Route::controller(OrderController::class)->group(function () {
        Route::get('order', 'showAll')->name('order.showAll');
        Route::get('order_all', 'index')->name('order.index');
        Route::get('order/{id}', 'show')->name('order.show');
        Route::get('getOrderUnpaid', 'getOrderUnpaid')->name('order.getOrderUnpaid');
        Route::get('check_order', 'check')->name('order.check');
        Route::get('find_time', 'findTimeAvailable')->name('order.findTimeAvailable');
        Route::post('findFootballPitchNotInOrderByDateTime', 'findFootballPitchNotInOrderByDateTime')->name('order.findFootballPitchNotInOrderByDateTime');
        Route::post('client_store', 'clientStore')->name('order.clientStore');
    });
    Route::controller(BankInformationController::class)->group(function () {
        Route::get('bank_information', 'index')->name('order.index');
    });
    Route::middleware('admin')->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::put('order/{id}', 'update')->name('order.update');
            Route::post('order', 'store')->name('order.store');
            Route::put('order-paid/{id}', 'paid')->name('order.paid');
            Route::delete('order/{id}', 'destroy')->name('order.destroy');
        });
        Route::controller(BankInformationController::class)->group(function () {
            Route::post('bank_information', 'store')->name('bank_information.store');
            Route::put('bank_information/{id}', 'update')->name('bank_information.update');
            Route::get('bank_information/{id}', 'show')->name('bank_information.show');
            Route::delete('bank_information/{id}', 'destroy')->name('bank_information.destroy');
            Route::put('bank_information_change_display/{id}', 'change_display')->name('bank_information.change_display');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('fetchEmploye', 'fetchEmploye')->name('user.fetchEmploye');
            Route::post('storeEmploye', 'storeEmploye')->name('user.storeEmploye');
            Route::delete('destroyEmploye/{id?}', 'destroyEmploye')->name('user.destroyEmploye');
            Route::put('updateEmploye/{id?}', 'updateEmploye')->name('user.updateEmploye');
            Route::get('showEmploye/{id?}', 'show')->name('user.showEmploye');
            Route::post('updateRoleEmploye/{id?}', 'updateRoleEmploye')->name('user.updateRoleEmploye');
            Route::get('fetchOwner', 'fetchOwner')->name('user.fetchOwner');
            Route::post('storeOwner', 'storeOwner')->name('user.storeOwner');
            Route::delete('destroyOwner/{id?}', 'destroyOwner')->name('user.destroyOwner');
            Route::put('updateOwner/{id?}', 'updateOwner')->name('user.updateOwner');
            Route::get('showOwner/{id?}', 'showOwner')->name('user.showOwner');
            Route::post('updateRoleOwner/{id?}', 'updateRoleOwner')->name('user.updateRoleOwner');
        });

        Route::controller(CustomerController::class)->group(function () {
            Route::get('fetchCustomer', 'fetchCustomer')->name('user.fetchCustomer');
            Route::post('storeCustomer', 'storeCustomer')->name('user.storeCustomer');
            Route::delete('destroyCustomer/{id?}', 'destroyCustomer')->name('user.destroyCustomer');
            Route::put('updateCustomer/{id?}', 'updateCustomer')->name('user.updateCustomer');
            Route::get('showCustomer/{id?}', 'show')->name('user.showCustomer');
            Route::post('updateRoleCustomer/{id?}', 'updateRoleCustomer')->name('user.updateRoleCustomer');
        });

        Route::controller(EquipmentController::class)->group(function () {
            // Route::get('fetchEquipment', 'fetchEquipment')->name('equipment.fetchEquipment');
            Route::post('storeEquipment', 'storeEquipment')->name('equipment.storeEquipment');
            Route::delete('destroyEquipment/{id?}', 'destroyEquipment')->name('equipment.destroyEquipment');
            Route::put('updateEquipment/{id?}', 'updateEquipment')->name('equipment.updateEquipment');
            Route::get('showEquipment/{id?}', 'show')->name('equipment.showEquipment');
        });

        Route::controller(IdentityPaperController::class)->group(function () {
            Route::get('showByUserId/{id?}', 'showByUserId')->name('identity_paper.showByUserId');
            Route::post('identity_paper', 'store')->name('identity_paper.store');
            Route::delete('identity_paper/{id?}', 'destroy')->name('identity_paper.destroy');
        });
    });
});