<?php

use App\Recap\Http\Controllers\RecapController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'exports', 'as' => 'exports.'], static function (Router $route) {
    $route->get('sales', [RecapController::class, 'sales'])->name('sales');
    $route->get('order', [RecapController::class, 'order'])->name('order');
});
