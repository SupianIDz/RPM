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
            $table->string('type');
            $table->integer('total_order')->default(0);
            $table->decimal('total_value', 10)->default(0);
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('recaps');
    }
};
