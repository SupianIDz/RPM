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
        Schema::create('order_items', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('invoice', 17);
            $table->string('name')->comment('Snapshot');
            $table->integer('quantity')->default(0);
            $table->foreignUuid('product_id')->constrained();
            $table->foreignUuid('product_price_id')->constrained();
            $table->timestamps();

            $table->foreign('invoice')->references('invoice')->on('orders')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('order_items');
    }
};
