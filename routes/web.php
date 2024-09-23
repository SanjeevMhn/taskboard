<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/',[TaskController::class,'index'])->name('task.index');
Route::put('/{id}',[TaskController::class,'updateCategory'])->name('task.update');

