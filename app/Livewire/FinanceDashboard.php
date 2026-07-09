<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\MonthlyFinance;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class FinanceDashboard extends Component
{
    // Authentication state
    public bool $isAuthenticated = false;
    public string $passwordInput = '';

    // List of monthly records
    public array $finances = [];

    // Global settings state
    public float $bolsa_auxilio;
    public float $alimentacao_dia;
    public float $transporte_dia;
    public float $dinheiro_mae;

    // Modal state controllers
    public bool $showFormModal = false;
    public bool $showSettingsModal = false;

    // Form fields for create/edit
    public ?int $editingId = null;
    public int $year;
    public int $month;
    public int $dias_trabalhados = 0;
    public float $conducao_dia = 0.0;
    public int $dias_conducao = 0;
    public float $recebido = 0.0;
    public float $caxinha = 300.0;
    public float $investimento = 200.0;
    public float $fatura = 300.0;

    // Automatic calculation preview in modal
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
    ];

    public function mount(): void
    {
        $this->isAuthenticated = session()->has('authenticated');

        $this->loadSettings();
        $this->loadFinances();

        // Defaults for form
        $this->year = (int) date('Y');
        $this->month = (int) date('n');
    }

    public function login(): void
    {
        $this->validate([
            'passwordInput' => 'required|string',
        ]);

        if (Hash::check($this->passwordInput, '$2y$12$ZqroavBefIsePQkTOiS6deWFP9TXNaEuwkpmnluNJR9uPignJThrq')) {
            session()->put('authenticated', true);
            $this->isAuthenticated = true;
            $this->passwordInput = '';
        } else {
            $this->addError('passwordInput', 'Senha incorreta!');
        }
    }

    public function loadSettings(): void
    {
        $this->bolsa_auxilio = (float) Setting::getValue('bolsa_auxilio', 1000.00);
        $this->alimentacao_dia = (float) Setting::getValue('alimentacao_dia', 20.00);
        $this->transporte_dia = (float) Setting::getValue('transporte_dia', 15.00);
        $this->dinheiro_mae = (float) Setting::getValue('dinheiro_mae', 100.00);
    }

    public function loadFinances(): void
    {
        $this->finances = MonthlyFinance::orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->all();
    }

    public function openSettingsModal(): void
    {
        $this->loadSettings();
        $this->showSettingsModal = true;
    }

    public function saveSettings(): void
    {
        $this->validate([
            'bolsa_auxilio' => 'required|numeric|min:0',
            'alimentacao_dia' => 'required|numeric|min:0',
            'transporte_dia' => 'required|numeric|min:0',
            'dinheiro_mae' => 'required|numeric|min:0',
        ]);

        Setting::setValue('bolsa_auxilio', $this->bolsa_auxilio);
        Setting::setValue('alimentacao_dia', $this->alimentacao_dia);
        Setting::setValue('transporte_dia', $this->transporte_dia);
        Setting::setValue('dinheiro_mae', $this->dinheiro_mae);

        $this->showSettingsModal = false;
        $this->dispatch('notify', ['message' => 'Configurações globais salvas com sucesso!']);
        
        // Refresh calculations for preview
        $this->recalculatePreviews();
    }

    public function openCreateModal(): void
    {
        $this->resetErrorBag();
        $this->editingId = null;
        
        // Suggest last month's year/month + 1
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
        } else {
            $this->year = (int) date('Y');
            $this->month = (int) date('n');
            $this->conducao_dia = 12.10;
            $this->caxinha = 300.0;
            $this->investimento = 200.0;
            $this->fatura = 300.0;
        }

        $this->dias_trabalhados = 20;
        $this->dias_conducao = 20;
        
        $this->recalculatePreviews();
        // Set default recebido to calculated preview
        $this->recebido = $this->previewSalarioTeorico;
        
        $this->showFormModal = true;
    }

    public function openEditModal(int $id): void
    {
        $this->resetErrorBag();
        $finance = MonthlyFinance::findOrFail($id);

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

        // Custom snapshot rates for preview calculation
        $this->previewSalarioTeorico = $finance->salario_teorico;
        $this->previewMae = $finance->total_mae;
        $this->previewSaldoFinal = $finance->saldo_final;

        $this->showFormModal = true;
    }

    public function updatedDiasTrabalhados($value): void
    {
        $this->dias_trabalhados = (int) $value;
        // Keep conduction days in sync unless manually modified (handy default)
        if ($this->dias_conducao === 0 || $this->dias_conducao === $this->dias_trabalhados - 1 || $this->dias_conducao === $this->dias_trabalhados + 1) {
            // Keep in sync
        }
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

    public function recalculatePreviews(): void
    {
        if ($this->editingId) {
            // Use snapshot values from existing record
            $finance = MonthlyFinance::find($this->editingId);
            if ($finance) {
                $sal = $finance->bolsa_auxilio_snapshot +
                    ($finance->alimentacao_dia_snapshot * $this->dias_trabalhados) +
                    ($finance->transporte_dia_snapshot * $this->dias_trabalhados);
                $mae = $finance->dinheiro_mae_snapshot + ($this->conducao_dia * $this->dias_conducao);
                
                $this->previewSalarioTeorico = round($sal, 2);
                $this->previewMae = round($mae, 2);
                $this->previewSaldoFinal = round($this->recebido - $this->previewMae - $this->caxinha - $this->investimento - $this->fatura, 2);
                return;
            }
        }

        // Use global values for new records
        $sal = $this->bolsa_auxilio + ($this->alimentacao_dia * $this->dias_trabalhados) + ($this->transporte_dia * $this->dias_trabalhados);
        $mae = $this->dinheiro_mae + ($this->conducao_dia * $this->dias_conducao);
        
        $this->previewSalarioTeorico = round($sal, 2);
        $this->previewMae = round($mae, 2);
        $this->previewSaldoFinal = round($this->recebido - $this->previewMae - $this->caxinha - $this->investimento - $this->fatura, 2);
    }

    public function saveFinance(): void
    {
        $this->validate();

        // Check unique month/year (exclude current editing record)
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
                // Capture snapshots of current global settings
                'bolsa_auxilio_snapshot' => $this->bolsa_auxilio,
                'alimentacao_dia_snapshot' => $this->alimentacao_dia,
                'transporte_dia_snapshot' => $this->transporte_dia,
                'dinheiro_mae_snapshot' => $this->dinheiro_mae,
            ]);
            $msg = 'Finanças mensais registradas com sucesso!';
        }

        $this->showFormModal = false;
        $this->loadFinances();
        $this->dispatch('notify', ['message' => $msg]);
    }

    public function deleteFinance(int $id): void
    {
        $finance = MonthlyFinance::findOrFail($id);
        $finance->delete();
        $this->loadFinances();
        $this->dispatch('notify', ['message' => 'Registro excluído com sucesso!']);
    }

    public function render(): View
    {
        return view('livewire.finance-dashboard')
            ->layout('components.layouts.app');
    }
}
