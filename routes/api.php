<?php

use App\Http\Controllers\AuthC;
use App\Http\Controllers\ChecklistC;
use App\Http\Controllers\ItemC;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthC::class, 'register']);
Route::post('/login', [AuthC::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::group(["prefix" => "/checklist"], function () {
        Route::get('/', [ChecklistC::class, 'index']);
        Route::post('/store', [ChecklistC::class, 'store']);
        Route::delete('/delete/{checklist}', [ChecklistC::class, 'destroy']);
    });

    Route::group(["prefix" => "/item"], function () {
        Route::get('/{checklist}/index', [ItemC::class, 'index']);
        Route::post('/{checklist}/store', [ItemC::class, 'store']);
        Route::put('/{checklist}/update-progress/{item}', [ItemC::class, 'updateStatus']);
        Route::delete('/{checklist}/delete/{item}', [ItemC::class, 'destroy']);
    });
});
