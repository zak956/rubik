<?php

use App\Http\Controllers\CubeController;
use App\Models\Cube;
use App\Processor\CubeProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (): JsonResponse {
    return new JsonResponse(['health' => 'OK']);
});

Route::get('/create', [CubeController::class, 'create']);
Route::get('/shuffle', [CubeController::class, 'shuffle']);
Route::get('/rotate/{face}/{direction}', [CubeController::class, 'rotate'])
    ->whereIn('face', Cube::FACES)
    ->whereIn('direction', [CubeProcessor::DIRECTION_CW, CubeProcessor::DIRECTION_CCW])
;
