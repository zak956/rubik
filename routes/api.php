<?php

use App\Enums\Directions;
use App\Enums\Faces;
use App\Http\Controllers\CubeController;
use App\Models\Cube;
use App\Processors\CubeProcessor;
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

Route::prefix('cube')->group(function () {
    Route::post('/create', [CubeController::class, 'create']);
    Route::get('/{cube}', [CubeController::class, 'get']);
    Route::get('/{cube}/init', [CubeController::class, 'init']);
    Route::get('/{cube}/shuffle', [CubeController::class, 'shuffle']);
    Route::get('/{cube}/rotate/{face}/{direction}', [CubeController::class, 'rotate'])
        ->whereIn('face', Faces::getValues())
        ->whereIn('direction', Directions::getValues())
    ;
});
