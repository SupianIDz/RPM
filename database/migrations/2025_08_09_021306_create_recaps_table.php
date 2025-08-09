<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('recaps', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('period');
            $table->integer('total_order_c')->default(0);
            $table->decimal('total_value_c', 10)->default(0);

            $table->integer('total_order_t')->default(0);
            $table->decimal('total_value_t', 10)->default(0);

            $table->integer('total_order_m')->default(0);
            $table->decimal('total_value_m', 10)->default(0);

            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('recaps');
    }
};
