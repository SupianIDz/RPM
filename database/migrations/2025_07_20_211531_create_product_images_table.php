<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('product_images', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->char('code', 9);
            $table->timestamps();
            $table->foreign('code')->references('code')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('product_images');
    }
};
