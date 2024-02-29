<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameDetailController;
use App\Http\Controllers\StadiumController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamLineupController;

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
    // Route::patch('user/change-password', [UserController::class, 'changePassword']);

    /* For Admin and Staff*/
    Route::group([
        'middleware' => 'check.admin.staff',
    ], function () {
        // // Player
        // Route::post('/players', [PlayerController::class, 'store']);
        // Route::patch('/players/{user_id}', [PlayerController::class, 'update']);
        // Route::delete('/players/{user_id}', [PlayerController::class, 'delete']);

        // // Coaches
        // Route::post('/coaches', [CoachController::class, 'store']);
        // Route::patch('/coaches/{user_id}', [CoachController::class, 'update']);
        // Route::delete('/coaches/{user_id}', [CoachController::class, 'delete']);

        // // Stadium
        // Route::post('/stadiums', [StadiumController::class, 'store']);
        // Route::patch('/stadiums/{id}', [StadiumController::class, 'update']);
        // Route::delete('/stadiums/{id}', [StadiumController::class, 'delete']);

        //Game

        //Game detail

        //Team up

        /* For Admin */


        /* For Staff */
    });

    /* For Member */

});

/* For Guest */
Route::post('/register-user', [UserController::class, 'store']);




//Coaches
Route::get('/coaches', [CoachController::class, 'index']);
Route::get('/coaches/{slug}', [CoachController::class, 'show']);


// Club
Route::get('/clubs', [ClubController::class, 'index']);
Route::get('/clubs/{id}', [ClubController::class, 'show']);
Route::post('/clubs', [ClubController::class, 'store']);
Route::patch('/clubs/{id}', [ClubController::class, 'update']);
Route::delete('/clubs/{id}', [ClubController::class, 'delete']);


// Player
// Players
Route::get('/players', [PlayerController::class, 'index']);
Route::get('/players/{slug}', [PlayerController::class, 'show']);
Route::get('/players/Id/{user_id}', [PlayerController::class, 'showId']);
Route::post('/players', [PlayerController::class, 'store']);
Route::patch('/players/{user_id}', [PlayerController::class, 'update']);
Route::delete('/players/{user_id}', [PlayerController::class, 'delete']);

// Coaches
Route::post('/coaches', [CoachController::class, 'store']);
Route::patch('/coaches/{user_id}', [CoachController::class, 'update']);
Route::delete('/coaches/{user_id}', [CoachController::class, 'delete']);

// Stadium
Route::post('/stadiums', [StadiumController::class, 'store']);
Route::patch('/stadiums/{id}', [StadiumController::class, 'update']);
Route::delete('/stadiums/{id}', [StadiumController::class, 'delete']);

// Stadium
Route::get('/stadiums', [StadiumController::class, 'index']);
Route::get('/stadiums/{id}', [StadiumController::class, 'show']);

//Games
Route::get('/matches', [GameController::class, 'index']);
Route::get('/match-live', [GameController::class, 'matchLive']);
Route::get('/match-history', [GameController::class, 'matchHistory']);
Route::get('/match-comeup', [GameController::class, 'matchComeUp']);
Route::get('/matches/{id}', [GameController::class, 'show']);

Route::post('/matches',[GameController::class, 'store']);
Route::patch('/matches/{id}',[GameController::class, 'update']);
Route::delete('/matches/{id}',[GameController::class, 'delete']);


// Game detail
Route::post('/match-detail',[GameDetailController::class, 'store']);
Route::patch('/match-detail/{id}',[GameDetailController::class, 'update']);
Route::delete('/match-detail/{id}',[GameDetailController::class, 'delete']);


// Contract
Route::get('/contracts',[ContractController::class, 'index']);
Route::get('/contracts/{id}',[ContractController::class, 'show']);
Route::get('contracts/type/{type}', [ContractController::class, 'getByType']);
Route::post('/contracts',[ContractController::class, 'store']);
Route::patch('/contracts/{id}',[ContractController::class, 'update']);
Route::delete('/contracts/{id}',[ContractController::class, 'delete']);

// User

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);

// Team lineup
Route::get('/lineup', [TeamLineupController::class, 'index']);
Route::post('/lineup', [TeamLineupController::class, 'store']);
Route::post('/lineup/{id}', [TeamLineupController::class, 'update']);
Route::delete('/lineup/{id}', [TeamLineupController::class, 'delete']);




//Test




//Test function
// Route::patch('/test-player/{user_id}', [TestController::class, 'updateImg']);
