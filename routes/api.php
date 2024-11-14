<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraineeController;


Route::apiResource('trainees', TraineeController::class);
Route::get('/trainees/search/{name}', [TraineeController::class, 'search']);