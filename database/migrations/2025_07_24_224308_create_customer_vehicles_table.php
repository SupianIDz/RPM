<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('customer_vehicles', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->constrained();
            $table->foreignUuid('vehicle_id')->constrained();
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('customer_vehicles');
    }
};
