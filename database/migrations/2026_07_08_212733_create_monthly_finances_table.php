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
        Schema::create('monthly_finances', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->integer('month');
            $table->integer('dias_trabalhados');
            $table->decimal('conducao_dia', 10, 2);
            $table->integer('dias_conducao');
            $table->decimal('recebido', 10, 2);
            $table->decimal('caxinha', 10, 2)->default(300.00);
            $table->decimal('investimento', 10, 2)->default(200.00);
            $table->decimal('fatura', 10, 2)->default(300.00);
            
            // Snapshots of global settings
            $table->decimal('bolsa_auxilio_snapshot', 10, 2);
            $table->decimal('alimentacao_dia_snapshot', 10, 2);
            $table->decimal('transporte_dia_snapshot', 10, 2);
            $table->decimal('dinheiro_mae_snapshot', 10, 2);

            $table->timestamps();

            // Prevent duplicate records for the same month and year
            $table->unique(['year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_finances');
    }
};
