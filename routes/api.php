<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'member'], function() {
    Route::get('/', [UserController::class, 'getUsers'])->name('usersApiList');
    Route::get('/user/{id}', [UserController::class, 'getUserById'])->name('singleUser');
    Route::get('/search', [UserController::class, 'getUserBySearchkeyWord'])->name('searchUser');
    Route::get('/filter', [UserController::class, 'filter'])->name('usersFilter');
    Route::get('/create', [UserController::class, 'createUser'])->name('createUser');
    Route::post('/store', [UserController::class, 'storeUser'])->name('storeUser');
    Route::get('/edit/{userId}', [UserController::class, 'edituser'])->name('edituser');
    Route::post('/update', [UserController::class, 'updateUser'])->name('updateUser');
    Route::delete('/delete/{userId}', [UserController::class, 'deleteUser'])->name('deleteUser');
    // Role assign to user
    Route::post('/assign-membersip-id', [UserController::class, 'assignMembershipId'])->name('assignMembershipIdToUser');
});
