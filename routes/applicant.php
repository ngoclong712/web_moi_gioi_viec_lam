<?php

use App\Http\Controllers\Applicant\HomePageController;

Route::get('/', [HomePageController::class, 'index'])->name('index');
