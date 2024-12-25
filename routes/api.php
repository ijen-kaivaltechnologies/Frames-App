<?php

use App\Http\Controllers\CatagoryController;
use App\Http\Controllers\FramesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(CatagoryController::class)->group(function(){
    Route::post('add_catagory', 'addCatagory');
    Route::post('show_catagory', 'showAllCatagory');
    Route::post('edit_catagory/{id}', 'editCatagory');
    Route::post('delete_catagory/{id}', 'delete_catagory');
});

Route::controller(FramesController::class)->group(function(){
    Route::post('add_frame', 'addFrame');
    Route::post('show_frame', 'showAllCatagory');
    Route::post('edit_frame/{id}', 'editCatagory');
    Route::post('delete_frme/{id}', 'delete_catagory');
});

