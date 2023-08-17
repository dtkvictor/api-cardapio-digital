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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user')->nullable();       
            $table->unsignedBigInteger('delivery_address')->nullable();
            $table->unsignedBigInteger('payment')->nullable();     
            $table->boolean('status')->default(false);            
            $table->timestamps();

            $table->foreign('user')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL');

            $table->foreign('delivery_address')
                ->references('id')
                ->on('addresses')
                ->onDelete('SET NULL');
            
            $table->foreign('payment')
                ->references('id')
                ->on('payment_methods')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
