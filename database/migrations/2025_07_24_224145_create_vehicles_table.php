<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('plate')->unique(); // e.g. DK 1234 AB
            $table->string('brand')->nullable(); // opsional: Honda, Yamaha
            $table->string('model')->nullable(); // opsional: Beat, Vario
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('vehicles');
    }
};
