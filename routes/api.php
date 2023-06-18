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
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('api')->group(function() {
    Route::get('/posts/featured', [ApiController::class, 'featured_posts']);
    Route::get('/posts/latest', [ApiController::class, 'latest_posts']);
    Route::get('/post/{slug}', [ApiController::class, 'fetch_post']);
    Route::get('/category/{category}/posts', [ApiController::class, 'category_posts'])->name('category_posts');
    Route::get('/settings', [ApiController::class, 'settings']);
    Route::post('/settings', [ApiController::class, 'store_settings']);
    Route::get('/stats', [ApiController::class, 'stats']);
    Route::get('/fixtures', [ApiController::class, 'fixtures']);
    Route::get('/fixtures/{id}', [ApiController::class, 'fixture']);
});
