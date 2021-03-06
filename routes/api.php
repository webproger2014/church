<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChurchController;
use App\Http\Controllers\UserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Hash;

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

  Route::get('test', function () {
    return Hash::make('jesushelp');
  });

  Route::middleware('auth:sanctum')->group(function () {
     Route::post('/info_account', function (Request $request) {
      return response()->json($request->user());
    });

    Route::prefix('/video')->group(function () {
      Route::post('add', [ChurchController::class, 'add_video']);
      Route::post('get_by_id', [ChurchController::class, 'get_video']);
      Route::post('get_list_categories', [ChurchController::class, 'get_list_categories']);
      Route::post('get_tags_video', [ChurchController::class, 'get_tags_video']);
      Route::post('filter', [ChurchController::class, 'get_videos']);
      Route::post('get_cats', [ChurchController::class, 'get_cats']);
    });

    Route::prefix('admin')->group(function () {
      Route::prefix('video')->group(function () {
        Route::post('add', [ChurchController::class, 'add_video']);
        Route::post('edit', [ChurchController::class, 'edit_video']);
        Route::post('active_video', [ChurchController::class, 'active_video']);
      });
      Route::prefix('users')->group(function () {
        Route::post('get_users', [UserController::class, 'get_users']);
      });
    });
  });

  //> AUTH
  Route::post('login', [Auth::class, 'auth']);
  //< AUTH
