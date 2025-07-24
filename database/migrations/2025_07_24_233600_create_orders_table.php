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
        Schema::create('orders', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('invoice')->unique();
            $table->string('type');
            $table->unsignedBigInteger('total')->default(0);
            $table->string('status');
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('vehicle_id')->nullable()->constrained('vehicles')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('orders');
    }
};
