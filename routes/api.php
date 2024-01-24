<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* For Auth */
Route::group([
    'middleware' => 'api',
], function () {


    Route::group(
        [
            'prefix' => 'auth',
        ],
        function () {
            Route::post('/login-user', [AuthController::class, 'loginUser']);
            Route::post('/login-admin', [AuthController::class, 'loginByID']);
            Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/me', [AuthController::class, 'me']);
        }
    );
    // Route::put('user/change-password', [UserController::class, 'changePassword']);

    /* For Admin and Staff*/
    Route::group([
        'middleware' => 'check.admin.staff',
    ], function () {
        // Route::post('/players', [PlayerController::class, 'store']);
        // Route::post('/coaches', [CoachController::class, 'store']);

        /* For Admin */


        /* For Staff */
    });

    /* For Member */

});

/* For Guest */
Route::post('/register-user', [UserController::class, 'store']);


// Players
Route::get('/players', [PlayerController::class, 'index']);
Route::get('/players/{slug}', [PlayerController::class, 'show']);

//Coaches
Route::get('/coaches', [CoachController::class, 'index']);
Route::get('/coaches/{slug}', [CoachController::class, 'show']);


//Test
Route::post('/players', [PlayerController::class, 'store']);
Route::put('/players/{user_id}', [PlayerController::class, 'update']);

