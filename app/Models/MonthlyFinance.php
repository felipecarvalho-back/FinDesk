<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyFinance extends Model
{
    protected $fillable = [
        'year',
        'month',
        'dias_trabalhados',
        'conducao_dia',
        'dias_conducao',
        'recebido',
        'caxinha',
        'investimento',
        'fatura',
        'bolsa_auxilio_snapshot',
        'alimentacao_dia_snapshot',
        'transporte_dia_snapshot',
        'dinheiro_mae_snapshot',
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
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'dias_trabalhados' => 'integer',
        'conducao_dia' => 'float',
        'dias_conducao' => 'integer',
        'recebido' => 'float',
        'caxinha' => 'float',
        'investimento' => 'float',
        'fatura' => 'float',
        'bolsa_auxilio_snapshot' => 'float',
        'alimentacao_dia_snapshot' => 'float',
        'transporte_dia_snapshot' => 'float',
        'dinheiro_mae_snapshot' => 'float',
        'extra_valor' => 'float',
        'ignorar_bolsa' => 'boolean',
        'ignorar_alimentacao' => 'boolean',
        'ignorar_transporte' => 'boolean',
        'ignorar_dinheiro_mae' => 'boolean',
        'ignorar_conducao' => 'boolean',
        'ignorar_caxinha' => 'boolean',
        'ignorar_investimento' => 'boolean',
        'ignorar_fatura' => 'boolean',
    ];

    private static array $monthsPt = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro',
    ];

    public function getMonthNameAttribute(): string
    {
        return self::$monthsPt[$this->month] ?? '';
    }

    public function getReceivingMonthNameAttribute(): string
    {
        $recMonth = $this->month === 12 ? 1 : $this->month + 1;

        return self::$monthsPt[$recMonth] ?? '';
    }

    public function getReceivingYearAttribute(): int
    {
        return $this->month === 12 ? $this->year + 1 : $this->year;
    }

    public function getSalarioTeoricoAttribute(): float
    {
        $bolsa = $this->ignorar_bolsa ? 0 : $this->bolsa_auxilio_snapshot;
        $alimentacao = $this->ignorar_alimentacao ? 0 : ($this->alimentacao_dia_snapshot * $this->dias_trabalhados);
        $transporte = $this->ignorar_transporte ? 0 : ($this->transporte_dia_snapshot * $this->dias_trabalhados);

        return round($bolsa + $alimentacao + $transporte, 2);
    }

    public function getTotalMaeAttribute(): float
    {
        $mae = $this->ignorar_dinheiro_mae ? 0 : $this->dinheiro_mae_snapshot;
        $conducao = $this->ignorar_conducao ? 0 : ($this->conducao_dia * $this->dias_conducao);

        return round($mae + $conducao, 2);
    }

    public function getSaldoFinalAttribute(): float
    {
        $saldo = $this->recebido - $this->total_mae;
        $saldo -= $this->ignorar_caxinha ? 0 : $this->caxinha;
        $saldo -= $this->ignorar_investimento ? 0 : $this->investimento;
        $saldo -= $this->ignorar_fatura ? 0 : $this->fatura;

        if ($this->extra_valor > 0) {
            if ($this->extra_tipo === 'entrada') {
                $saldo += $this->extra_valor;
            } else {
                $saldo -= $this->extra_valor;
            }
        }

        return round($saldo, 2);
    }
}
