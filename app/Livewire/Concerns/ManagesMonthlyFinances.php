<?php

namespace App\Livewire\Concerns;

use App\Models\MonthlyFinance;

trait ManagesMonthlyFinances
{
    public bool $showFormModal = false;

    public ?int $editingId = null;

    public int $year;

    public int $month;

    public int $dias_trabalhados = 0;

    public float $conducao_dia = 0.0;

    public int $dias_conducao = 0;

    public float $recebido = 0.0;

    public float $caxinha = 0.0;

    public float $investimento = 0.0;

    public float $fatura = 0.0;

    public float $internet = 0.0;

    public float $gemini = 0.0;

    public string $extra_nome = 'Extra';

    public float $extra_valor = 0.0;

    public string $extra_tipo = 'saida';

    public bool $ignorar_bolsa = false;

    public bool $ignorar_alimentacao = false;

    public bool $ignorar_transporte = false;

    public bool $ignorar_dinheiro_mae = false;

    public bool $ignorar_conducao = false;

    public bool $ignorar_caxinha = false;

    public bool $ignorar_investimento = false;

    public bool $ignorar_fatura = false;

    public bool $ignorar_internet = false;

    public bool $ignorar_gemini = false;

    public string $formTab = 'basico';

    public float $previewSalarioTeorico = 0.0;

    public float $previewMae = 0.0;

    public float $previewSaldoFinal = 0.0;

    protected array $rules = [
        'year' => 'required|integer|min:2000|max:2100',
        'month' => 'required|integer|between:1,12',
        'dias_trabalhados' => 'required|integer|min:0',
        'conducao_dia' => 'required|numeric|min:0',
        'dias_conducao' => 'required|integer|min:0',
        'recebido' => 'required|numeric|min:0',
        'caxinha' => 'required|numeric|min:0',
        'investimento' => 'required|numeric|min:0',
        'fatura' => 'required|numeric|min:0',
        'internet' => 'required|numeric|min:0',
        'gemini' => 'required|numeric|min:0',
        'extra_nome' => 'nullable|string|max:50',
        'extra_valor' => 'required|numeric|min:0',
        'extra_tipo' => 'required|in:entrada,saida',
        'ignorar_bolsa' => 'required|boolean',
        'ignorar_alimentacao' => 'required|boolean',
        'ignorar_transporte' => 'required|boolean',
        'ignorar_dinheiro_mae' => 'required|boolean',
        'ignorar_conducao' => 'required|boolean',
        'ignorar_caxinha' => 'required|boolean',
        'ignorar_investimento' => 'required|boolean',
        'ignorar_fatura' => 'required|boolean',
        'ignorar_internet' => 'required|boolean',
        'ignorar_gemini' => 'required|boolean',
    ];

    public function openCreateModal(): void
    {
        $this->resetErrorBag();
        $this->editingId = null;
        $this->formTab = 'basico';

        $latest = MonthlyFinance::orderBy('year', 'desc')->orderBy('month', 'desc')->first();
        if ($latest) {
            if ($latest->month === 12) {
                $this->year = $latest->year + 1;
                $this->month = 1;
            } else {
                $this->year = $latest->year;
                $this->month = $latest->month + 1;
            }
            $this->conducao_dia = $latest->conducao_dia;
            $this->caxinha = $latest->caxinha;
            $this->investimento = $latest->investimento;
            $this->fatura = $latest->fatura;
            $this->internet = $latest->internet > 0 ? $latest->internet : $this->internet_padrao;
            $this->gemini = $latest->gemini > 0 ? $latest->gemini : $this->gemini_padrao;
        } else {
            $this->year = (int) date('Y');
            $this->month = (int) date('n');
            $this->conducao_dia = 12.10;
            $this->caxinha = 300.0;
            $this->investimento = 200.0;
            $this->fatura = 300.0;
            $this->internet = $this->internet_padrao;
            $this->gemini = $this->gemini_padrao;
        }

        $this->dias_trabalhados = 20;
        $this->dias_conducao = 20;

        $this->extra_nome = 'Extra';
        $this->extra_valor = 0.0;
        $this->extra_tipo = 'saida';
        $this->ignorar_bolsa = false;
        $this->ignorar_alimentacao = false;
        $this->ignorar_transporte = false;
        $this->ignorar_dinheiro_mae = false;
        $this->ignorar_conducao = false;
        $this->ignorar_caxinha = false;
        $this->ignorar_investimento = false;
        $this->ignorar_fatura = false;
        $this->ignorar_internet = false;
        $this->ignorar_gemini = false;

        $this->recalculatePreviews();
        $this->recebido = $this->previewSalarioTeorico;

        $this->showFormModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetErrorBag();
        $finance = MonthlyFinance::findOrFail($id);
        $this->formTab = 'basico';

        $this->editingId = $finance->id;
        $this->year = $finance->year;
        $this->month = $finance->month;
        $this->dias_trabalhados = $finance->dias_trabalhados;
        $this->conducao_dia = $finance->conducao_dia;
        $this->dias_conducao = $finance->dias_conducao;
        $this->recebido = $finance->recebido;
        $this->caxinha = $finance->caxinha;
        $this->investimento = $finance->investimento;
        $this->fatura = $finance->fatura;
        $this->internet = (float) $finance->internet > 0
            ? (float) $finance->internet
            : $this->internet_padrao;
        $this->gemini = (float) $finance->gemini > 0
            ? (float) $finance->gemini
            : $this->gemini_padrao;
        $this->extra_nome = $finance->extra_nome ?? 'Extra';
        $this->extra_valor = (float) $finance->extra_valor;
        $this->extra_tipo = $finance->extra_tipo ?? 'saida';
        $this->ignorar_bolsa = (bool) $finance->ignorar_bolsa;
        $this->ignorar_alimentacao = (bool) $finance->ignorar_alimentacao;
        $this->ignorar_transporte = (bool) $finance->ignorar_transporte;
        $this->ignorar_dinheiro_mae = (bool) $finance->ignorar_dinheiro_mae;
        $this->ignorar_conducao = (bool) $finance->ignorar_conducao;
        $this->ignorar_caxinha = (bool) $finance->ignorar_caxinha;
        $this->ignorar_investimento = (bool) $finance->ignorar_investimento;
        $this->ignorar_fatura = (bool) $finance->ignorar_fatura;
        $this->ignorar_internet = (bool) $finance->ignorar_internet;
        $this->ignorar_gemini = (bool) $finance->ignorar_gemini;

        $this->recalculatePreviews();

        $this->showFormModal = true;
    }

    public function updated($property): void
    {
        if (in_array($property, [
            'extra_nome', 'extra_valor', 'extra_tipo',
            'ignorar_bolsa', 'ignorar_alimentacao', 'ignorar_transporte',
            'ignorar_dinheiro_mae', 'ignorar_conducao', 'ignorar_caxinha',
            'ignorar_investimento', 'ignorar_fatura', 'ignorar_internet', 'ignorar_gemini',
            'internet', 'gemini',
        ])) {
            $this->recalculatePreviews();
        }
    }

    public function updatedDiasTrabalhados($value): void
    {
        $this->dias_trabalhados = (int) $value;
        $this->dias_conducao = $this->dias_trabalhados;
        $this->recalculatePreviews();
        $this->recebido = $this->previewSalarioTeorico;
    }

    public function updatedDiasConducao($value): void
    {
        $this->dias_conducao = (int) $value;
        $this->recalculatePreviews();
    }

    public function updatedConducaoDia($value): void
    {
        $this->conducao_dia = (float) $value;
        $this->recalculatePreviews();
    }

    public function updatedRecebido($value): void
    {
        $this->recebido = (float) $value;
        $this->recalculatePreviews();
    }

    public function updatedCaxinha($value): void
    {
        $this->caxinha = (float) $value;
        $this->recalculatePreviews();
    }

    public function updatedInvestimento($value): void
    {
        $this->investimento = (float) $value;
        $this->recalculatePreviews();
    }

    public function updatedFatura($value): void
    {
        $this->fatura = (float) $value;
        $this->recalculatePreviews();
    }

    public function updatedInternet($value): void
    {
        $this->internet = (float) $value;
        $this->recalculatePreviews();
    }

    public function updatedGemini($value): void
    {
        $this->gemini = (float) $value;
        $this->recalculatePreviews();
    }

    public function recalculatePreviews(): void
    {
        if ($this->editingId) {
            $finance = MonthlyFinance::find($this->editingId);
            if ($finance) {
                $sal = ($this->ignorar_bolsa ? 0 : $finance->bolsa_auxilio_snapshot) +
                    ($this->ignorar_alimentacao ? 0 : $finance->alimentacao_dia_snapshot * $this->dias_trabalhados) +
                    ($this->ignorar_transporte ? 0 : $finance->transporte_dia_snapshot * $this->dias_trabalhados);
                $mae = ($this->ignorar_dinheiro_mae ? 0 : $finance->dinheiro_mae_snapshot) +
                    ($this->ignorar_conducao ? 0 : $this->conducao_dia * $this->dias_conducao);

                $this->previewSalarioTeorico = round($sal, 2);
                $this->previewMae = round($mae, 2);

                $saldo = $this->recebido - $this->previewMae;
                $saldo -= $this->ignorar_caxinha ? 0 : $this->caxinha;
                $saldo -= $this->ignorar_investimento ? 0 : $this->investimento;
                $saldo -= $this->ignorar_fatura ? 0 : $this->fatura;
                $saldo -= $this->ignorar_internet ? 0 : $this->internet;
                $saldo -= $this->ignorar_gemini ? 0 : $this->gemini;

                if ($this->extra_valor > 0) {
                    if ($this->extra_tipo === 'entrada') {
                        $saldo += $this->extra_valor;
                    } else {
                        $saldo -= $this->extra_valor;
                    }
                }

                $this->previewSaldoFinal = round($saldo, 2);

                return;
            }
        }

        $sal = ($this->ignorar_bolsa ? 0 : $this->bolsa_auxilio) +
            ($this->ignorar_alimentacao ? 0 : $this->alimentacao_dia * $this->dias_trabalhados) +
            ($this->ignorar_transporte ? 0 : $this->transporte_dia * $this->dias_trabalhados);
        $mae = ($this->ignorar_dinheiro_mae ? 0 : $this->dinheiro_mae) +
            ($this->ignorar_conducao ? 0 : $this->conducao_dia * $this->dias_conducao);

        $this->previewSalarioTeorico = round($sal, 2);
        $this->previewMae = round($mae, 2);

        $saldo = $this->recebido - $this->previewMae;
        $saldo -= $this->ignorar_caxinha ? 0 : $this->caxinha;
        $saldo -= $this->ignorar_investimento ? 0 : $this->investimento;
        $saldo -= $this->ignorar_fatura ? 0 : $this->fatura;
        $saldo -= $this->ignorar_internet ? 0 : $this->internet;
        $saldo -= $this->ignorar_gemini ? 0 : $this->gemini;

        if ($this->extra_valor > 0) {
            if ($this->extra_tipo === 'entrada') {
                $saldo += $this->extra_valor;
            } else {
                $saldo -= $this->extra_valor;
            }
        }

        $this->previewSaldoFinal = round($saldo, 2);
    }

    public function saveFinance(): void
    {
        $this->validate();

        $exists = MonthlyFinance::where('year', $this->year)
            ->where('month', $this->month)
            ->where('id', '!=', $this->editingId)
            ->exists();

        if ($exists) {
            $this->addError('month', 'Já existe um registro financeiro para este mês e ano.');

            return;
        }

        if ($this->editingId) {
            $finance = MonthlyFinance::findOrFail($this->editingId);
            $finance->update([
                'year' => $this->year,
                'month' => $this->month,
                'dias_trabalhados' => $this->dias_trabalhados,
                'conducao_dia' => $this->conducao_dia,
                'dias_conducao' => $this->dias_conducao,
                'recebido' => $this->recebido,
                'caxinha' => $this->caxinha,
                'investimento' => $this->investimento,
                'fatura' => $this->fatura,
                'internet' => $this->internet,
                'gemini' => $this->gemini,
                'extra_nome' => $this->extra_nome,
                'extra_valor' => $this->extra_valor,
                'extra_tipo' => $this->extra_tipo,
                'ignorar_bolsa' => $this->ignorar_bolsa,
                'ignorar_alimentacao' => $this->ignorar_alimentacao,
                'ignorar_transporte' => $this->ignorar_transporte,
                'ignorar_dinheiro_mae' => $this->ignorar_dinheiro_mae,
                'ignorar_conducao' => $this->ignorar_conducao,
                'ignorar_caxinha' => $this->ignorar_caxinha,
                'ignorar_investimento' => $this->ignorar_investimento,
                'ignorar_fatura' => $this->ignorar_fatura,
                'ignorar_internet' => $this->ignorar_internet,
                'ignorar_gemini' => $this->ignorar_gemini,
            ]);
            $msg = 'Finanças atualizadas com sucesso!';
        } else {
            MonthlyFinance::create([
                'year' => $this->year,
                'month' => $this->month,
                'dias_trabalhados' => $this->dias_trabalhados,
                'conducao_dia' => $this->conducao_dia,
                'dias_conducao' => $this->dias_conducao,
                'recebido' => $this->recebido,
                'caxinha' => $this->caxinha,
                'investimento' => $this->investimento,
                'fatura' => $this->fatura,
                'internet' => $this->internet,
                'gemini' => $this->gemini,
                'bolsa_auxilio_snapshot' => $this->bolsa_auxilio,
                'alimentacao_dia_snapshot' => $this->alimentacao_dia,
                'transporte_dia_snapshot' => $this->transporte_dia,
                'dinheiro_mae_snapshot' => $this->dinheiro_mae,
                'internet_snapshot' => $this->internet_padrao,
                'gemini_snapshot' => $this->gemini_padrao,
                'extra_nome' => $this->extra_nome,
                'extra_valor' => $this->extra_valor,
                'extra_tipo' => $this->extra_tipo,
                'ignorar_bolsa' => $this->ignorar_bolsa,
                'ignorar_alimentacao' => $this->ignorar_alimentacao,
                'ignorar_transporte' => $this->ignorar_transporte,
                'ignorar_dinheiro_mae' => $this->ignorar_dinheiro_mae,
                'ignorar_conducao' => $this->ignorar_conducao,
                'ignorar_caxinha' => $this->ignorar_caxinha,
                'ignorar_investimento' => $this->ignorar_investimento,
                'ignorar_fatura' => $this->ignorar_fatura,
                'ignorar_internet' => $this->ignorar_internet,
                'ignorar_gemini' => $this->ignorar_gemini,
            ]);
            $msg = 'Finanças mensais registradas com sucesso!';
        }

        $this->showFormModal = false;
        $this->currentScreen = 'meses';
        $this->loadFinances();
        $this->notify($msg);
    }

    public function viewMonth(int $id): void
    {
        $this->openEditModal($id);
        $this->showFormModal = false;
        $this->currentScreen = 'detalhes';
    }

    public function deleteFinance(int $id): void
    {
        $finance = MonthlyFinance::findOrFail($id);
        $finance->delete();
        $this->loadFinances();
        $this->notify('Registro excluído com sucesso!');
    }
}
