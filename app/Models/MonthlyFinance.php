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
        return round($this->bolsa_auxilio_snapshot +
            ($this->alimentacao_dia_snapshot * $this->dias_trabalhados) +
            ($this->transporte_dia_snapshot * $this->dias_trabalhados), 2);
    }

    public function getTotalMaeAttribute(): float
    {
        return round($this->dinheiro_mae_snapshot + ($this->conducao_dia * $this->dias_conducao), 2);
    }

    public function getSaldoFinalAttribute(): float
    {
        return round($this->recebido - $this->total_mae - $this->caxinha - $this->investimento - $this->fatura, 2);
    }
}
