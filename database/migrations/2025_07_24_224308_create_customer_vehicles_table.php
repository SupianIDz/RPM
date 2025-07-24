<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('customer_vehicle', static function (Blueprint $table) {
            $table->foreignUuid('customer_id')->constrained();
            $table->foreignUuid('vehicle_id')->constrained();
            $table->primary([
                'customer_id', 'vehicle_id',
            ]);
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('customer_vehicles');
    }
};
