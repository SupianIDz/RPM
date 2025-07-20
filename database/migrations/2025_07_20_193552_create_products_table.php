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
        Schema::create('products', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('stock')->default(0);
            $table->foreignUuid('unit_id')->constrained('units')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('category_id')->constrained('categories')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('brand_id')->constrained('brands')->restrictOnDelete()->cascadeOnUpdate();
            $table->boolean('active')->default(true);
            $table->foreignUuid('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('products');
    }
};
