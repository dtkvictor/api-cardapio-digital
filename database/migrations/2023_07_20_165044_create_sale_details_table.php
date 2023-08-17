<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale');
            $table->unsignedBigInteger('product')->nullable();
            $table->boolean('hidden')->default(false);
            $table->integer('quantity');
            $table->float('price');
            $table->integer('discount')->default(0);            
            $table->timestamps();

            $table->foreign('sale')
                ->references('id')
                ->on('sales')
                ->onDelete('CASCADE');

            $table->foreign('product')
                ->references('id')
                ->on('products')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
