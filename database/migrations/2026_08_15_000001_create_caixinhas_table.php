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
        Schema::create('caixinhas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('target_amount', 12, 2)->nullable();
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('color')->default('indigo');
            $table->string('icon')->default('piggy');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixinhas');
    }
};
