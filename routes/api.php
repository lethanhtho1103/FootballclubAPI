<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;

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

Route::post('/register', [AuthController::class, 'register']);


/* For Auth */
Route::group([
    'middleware' => 'api',
], function () {
    Route::group(
        [
            'prefix' => 'auth',
        ],
        function () {
            Route::post('/login_user', [AuthController::class, 'loginUser']);
            Route::post('/login', [AuthController::class, 'loginByID']);
            Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/me', [AuthController::class, 'me']);
        }
    );
    // Route::put('user/change-password', [UserController::class, 'changePassword']);

    /* For Admin and Staff*/
    Route::group([
        'middleware' => 'check.admin.staff',
        'prefix' => 'admin'
    ], function () {
        Route::post('/register-player', [PlayerController::class, 'register']);
        Route::post('/register-coach', [CoachController::class, 'register']);
    });

    /* For Member */

});

/* For Guest */
