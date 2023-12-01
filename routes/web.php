<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UtilityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\LandingPageController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LandingPageController::class, 'viewLandingPage'])->name('homepage');
Route::get('/register', [LandingPageController::class, 'viewLandingPage'])->name('registration');

Auth::routes();

// admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function() {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    // // Roles routes
    // Route::group(['prefix' => 'roles'], function() {
    //     Route::get('/', [RolesController::class, 'index'])->name('rolesList');
    //     Route::get('/create', [RolesController::class, 'create'])->name('createRoles');
    //     Route::post('/store', [RolesController::class, 'store'])->name('storeRoles');
    //     Route::get('/edit/{id}', [RolesController::class, 'edit'])->name('editRoles');
    //     Route::patch('/update/{id}', [RolesController::class, 'update'])->name('updateRoles');
    // });

    // // Room types routes
    // Route::group(['prefix' => 'room-types'], function() {
    //     Route::get('/', [RoomTypesController::class, 'index'])->name('roomTypesList');
    //     Route::get('/create', [RoomTypesController::class, 'create'])->name('createRoomType');
    //     Route::get('/edit/{room_type_id}', [RoomTypesController::class, 'edit'])->name('editRoomType');
    //     Route::post('/store', [RoomTypesController::class, 'create'])->name('storeRoomType');
    //     Route::delete('/delete/{room_type_id}', [RoomTypesController::class, 'destroy'])->name('deleteRoomType');
    // });

    // Activity Log routes
    // Route::group(['prefix' => 'activity-log'], function() {
    //     Route::get('/', [AdminUtilityController::class, 'getActivityLogs'])->name('activityLogs');
    // });

    // User routes
    Route::group(['prefix' => 'member'], function() {
        Route::get('/', [UserController::class, 'getUsers'])->name('usersList');
        Route::get('/filter', [UserController::class, 'filter'])->name('usersFilter');
        Route::get('/create', [UserController::class, 'createUser'])->name('createUser');
        Route::post('/store', [UserController::class, 'storeUser'])->name('storeUser');
        Route::get('/edit/{userId}', [UserController::class, 'edituser'])->name('edituser');
        Route::post('/update', [UserController::class, 'updateUser'])->name('updateUser');
        Route::delete('/delete/{userId}', [UserController::class, 'deleteUser'])->name('deleteUser');
        // Role assign to user
        Route::post('/assign-membersip-id', [UserController::class, 'assignMembershipId'])->name('assignMembershipIdToUser');
    });
    // User routes
    Route::group(['prefix' => 'user-profile'], function() {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::post('/update', [UserController::class, 'profileUpdate'])->name('profile.uddate');
        Route::post('/reset/password', [UserController::class, 'resetPassword'])->name('profile.reset-password');
    });

    Route::group(['prefix' => 'contact'], function() {
        Route::get('/', [UtilityController::class, 'contactUsView'])->name('contact');
        Route::post('/', [UtilityController::class, 'storeAndSendContactMessage'])->name('contact.submit');
    });

    Route::group(['prefix' => 'payment'], function() {
        Route::get('/', [PaymentController::class, 'view'])->name('payment');
        Route::get('/filter', [PaymentController::class, 'filter'])->name('payment.filter');
        Route::post('/', [PaymentController::class, 'store'])->name('payment.store');
        Route::post('/update/{id}', [PaymentController::class, 'update'])->name('payment.update');
        Route::get('/updateStatus/{id}/{status}', [PaymentController::class, 'updateStatus'])->name('payment.update.status');
    });

    Route::group(['prefix' => 'error'], function() {
        Route::get('404', function(){
            return view('errorPages.404');
        })->name('not-found');
        Route::get('500', function(){
            return view('errorPages.500');
        })->name('server-issue');
    });
});
