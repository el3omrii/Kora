<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/matchs/fixtures', [ApiController::class, 'fixtures']);
    Route::post('/translations', [ApiController::class, 'translations']);
    Route::put('/translations/{translation}', [ApiController::class, 'saveTranslation']);
    Route::post('/matchs/scheduled', [ApiController::class, 'scheduled']);
    Route::post('/matchs/publish', [ApiController::class, 'publish']);
});