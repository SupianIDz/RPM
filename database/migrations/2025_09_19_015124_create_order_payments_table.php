<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up() : void
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('invoice', 17);
            $table->string('type');
            $table->decimal('amount', 18, 2);
            $table->timestamps();

            $table->foreign('invoice')->references('invoice')->on('orders')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('order_payments');
    }
};
