<?php

use App\Enums\Directions;
use App\Enums\Faces;
use App\Http\Controllers\CubeController;
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

Route::prefix('cube')->group(function () {
    Route::post('/create', [CubeController::class, 'create']);
    Route::get('/{cube}', [CubeController::class, 'get'])->whereNumber('cube');
    Route::get('/{cube}/init', [CubeController::class, 'init'])->whereNumber('cube');
    Route::get('/{cube}/shuffle', [CubeController::class, 'shuffle'])->whereNumber('cube');
    Route::get('/{cube}/rotate/{face}/{direction}', [CubeController::class, 'rotate'])
        ->whereNumber('cube')
        ->whereIn('face', Faces::getValues())
        ->whereIn('direction', Directions::getValues())
    ;
});
