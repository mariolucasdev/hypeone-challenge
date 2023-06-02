<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/chats', [ChatController::class, 'index']);

Route::post('/chat', [ChatController::class, 'start']);

Route::get('/chat/{id}/details', [ChatController::class, 'details']);

Route::put('/chat/{id}/close', [ChatController::class, 'close']);

Route::get('/chat/{id}/join', [ChatController::class, 'join']);

Route::get('/message/{chatid}', [MessageController::class, 'index']);

Route::post('/message/store', [MessageController::class, 'store']);
