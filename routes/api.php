<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChurchController;

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

Route::prefix('/video')->group(function () {
  Route::any('add', [ChurchController::class, 'add_video']);
  Route::any('get_by_id', [ChurchController::class, 'get_video']);
  Route::any('get_list_categories', [ChurchController::class, 'get_list_categories']);
  Route::post('filter', [ChurchController::class, 'get_videos']);
});
