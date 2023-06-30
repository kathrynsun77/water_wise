<?php

use App\Http\Controllers\Api\DownloadReport;
use App\Http\Controllers\Api\fcmController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/pdf', [DownloadReport::class, 'generatePdf']);
Route::post('/pdf', [DownloadReport::class, 'generatePdf']);
Route::post('/sendMessage', [fcmController::class, 'sendMessage']);



