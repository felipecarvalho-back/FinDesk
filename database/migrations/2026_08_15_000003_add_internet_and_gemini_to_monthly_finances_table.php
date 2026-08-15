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
        Schema::table('monthly_finances', function (Blueprint $table) {
            $table->decimal('internet', 10, 2)->default(0.00);
            $table->decimal('gemini', 10, 2)->default(0.00);
            $table->decimal('internet_snapshot', 10, 2)->default(0.00);
            $table->decimal('gemini_snapshot', 10, 2)->default(0.00);
            $table->boolean('ignorar_internet')->default(false);
            $table->boolean('ignorar_gemini')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_finances', function (Blueprint $table) {
            $table->dropColumn([
                'internet',
                'gemini',
                'internet_snapshot',
                'gemini_snapshot',
                'ignorar_internet',
                'ignorar_gemini',
            ]);
        });
    }
};
