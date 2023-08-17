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
        Schema::create('hierarchy_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hierarchy');
            $table->unsignedBigInteger('permission');
            $table->timestamps();

            $table->foreign('hierarchy')
                ->references('id')
                ->on('hierarchies')
                ->onDelete('CASCADE');

            $table->foreign('permission')
                ->references('id')
                ->on('permissions')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hierarchy_permissions');
    }
};
