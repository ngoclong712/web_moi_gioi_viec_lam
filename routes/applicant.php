<?php

use App\Http\Controllers\Applicant\HomePageController;

Route::get('/', [HomePageController::class, 'index'])->name('index');
Route::get('/{post}', [HomePageController::class, 'show'])->name('show');
