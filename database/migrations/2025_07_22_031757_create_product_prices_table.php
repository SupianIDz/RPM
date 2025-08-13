<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('product_prices', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('code', 9);
            $table->decimal('cogs', 10, 2)->default(0)->comment('Cost of Goods Sold');
            $table->decimal('amount', 10, 2)->default(0);
            $table->foreignUuid('created_by')->nullable()->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('code')->references('code')->on('products')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('product_prices');
    }
};
