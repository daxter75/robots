<?php

use \App\Http\Controllers\RobotController;
use \App\Http\Controllers\DanceoffController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('robots', [RobotController::class, 'index']);
Route::get('robots/{robot:id}', [RobotController::class, 'show']);

Route::get('danceoffs', [DanceoffController::class, 'index']);
Route::get('danceoffs/populated', [DanceoffController::class, 'populated']);

Route::fallback(function (Request $request) {
    return response()->json([
        'statusCode' => 404,
        'error' => 'Not Found!',
        'message' => 'Not found URI: ' . $request->getMethod() . ' ' . $request->getRequestUri(),
    ], 404);
});
