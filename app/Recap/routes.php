<?php

use App\Recap\Http\Controllers\RecapController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'exports', 'as' => 'exports.'], static function () {
    Route::get('sales', [RecapController::class, 'sales'])->name('sales');
});
