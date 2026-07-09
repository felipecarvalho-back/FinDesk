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
            $table->string('extra_nome', 50)->nullable()->default('Extra');
            $table->decimal('extra_valor', 10, 2)->default(0.00);
            $table->string('extra_tipo', 10)->default('saida'); // 'entrada' ou 'saida'
            $table->boolean('ignorar_bolsa')->default(false);
            $table->boolean('ignorar_alimentacao')->default(false);
            $table->boolean('ignorar_transporte')->default(false);
            $table->boolean('ignorar_dinheiro_mae')->default(false);
            $table->boolean('ignorar_conducao')->default(false);
            $table->boolean('ignorar_caxinha')->default(false);
            $table->boolean('ignorar_investimento')->default(false);
            $table->boolean('ignorar_fatura')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monthly_finances', function (Blueprint $table) {
            $table->dropColumn([
                'extra_nome',
                'extra_valor',
                'extra_tipo',
                'ignorar_bolsa',
                'ignorar_alimentacao',
                'ignorar_transporte',
                'ignorar_dinheiro_mae',
                'ignorar_conducao',
                'ignorar_caxinha',
                'ignorar_investimento',
                'ignorar_fatura',
            ]);
        });
    }
};
