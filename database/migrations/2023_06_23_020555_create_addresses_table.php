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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user');
            $table->string('zipcode', 8);
            $table->string('state', 255);
            $table->string('city', 255); 
            $table->string('neighborhood', 500);
            $table->string('street_address', 500);
            $table->string('number', 10);
            $table->text('complement');
            $table->timestamps();

            $table->foreign('user')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
