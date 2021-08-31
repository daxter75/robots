<?php

use \App\Http\Controllers\RobotController;
use \App\Http\Controllers\DanceoffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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

Route::get('robots', [RobotController::class, 'index']);
Route::get('robots/{robot:id}', [RobotController::class, 'show']);

Route::get('danceoffs', [DanceoffController::class, 'index']);
Route::post('danceoffs', [DanceoffController::class, 'store']);
Route::get('danceoffs/populated', [DanceoffController::class, 'populated']);

Route::get('leaderboard', [DanceoffController::class, 'leaderboard']);

Route::fallback(function (Request $request) {
    return response()->json([
        'statusCode' => Response::HTTP_NOT_FOUND,
        'error' => 'Not Found!',
        'message' => 'URI: ' . $request->getMethod() . ' ' . $request->getRequestUri() . ' not found',
    ], Response::HTTP_NOT_FOUND);
});
