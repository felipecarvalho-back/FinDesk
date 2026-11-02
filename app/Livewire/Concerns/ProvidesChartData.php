<?php

namespace App\Livewire\Concerns;

use App\Models\Caixinha;
use App\Models\Investment;

trait ProvidesChartData
{
    public function getTotalCaixinhasBalance(): float
    {
        return (float) Caixinha::sum('balance');
    }

    public function getTotalInvestmentsAmount(): float
    {
        return (float) Investment::sum('amount');
    }

    public function getChartLabels(): array
    {
        return $this->finances->map(function ($f) {
            return $f->month_name.' / '.$f->year;
        })->toArray();
    }

    public function getChartRecebido(): array
    {
        return $this->finances->map(function ($f) {
            return (float) $f->recebido;
        })->toArray();
    }

    public function getChartSobrou(): array
    {
        return $this->finances->map(function ($f) {
            return (float) $f->saldo_final;
        })->toArray();
    }

    public function getChartTotalCaxinha(): float
    {
        return (float) $this->finances->sum('caxinha');
    }

    public function getChartTotalInvestimento(): float
    {
        return (float) $this->finances->sum('investimento');
    }

    public function getChartTotalFatura(): float
    {
        return (float) $this->finances->sum('fatura');
    }

    public function getChartTotalInternet(): float
    {
        return (float) $this->finances->sum('internet');
    }

    public function getChartTotalGemini(): float
    {
        return (float) $this->finances->sum('gemini');
    }

    public function getChartTotalMae(): float
    {
        return (float) $this->finances->sum('total_mae');
    }
}
