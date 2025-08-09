<?php

use App\Order\Http\Controllers\ReceiptController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'web'], 'as' => 'orders.'], static function (Router $router) {
    $router->get('receipt/{order}', ReceiptController::class)->name('receipt');
});
