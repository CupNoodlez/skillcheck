<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'student'], function() {
    
    Route::get('dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('examList', [StudentController::class, 'examList'])->name('examList');
    Route::get('scoreHistory', [StudentController::class, 'scoreHistory'])->name('scoreHistory');

});

Route::group(['prefix' => 'admin'], function() {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('createExam', [AdminController::class, 'createExam'])->name('createExam');
    Route::get('questionBank', [AdminController::class, 'questionBank'])->name('questionBank');

});
