<?php

namespace App\Livewire;

use App\Models\Caixinha;
use App\Models\Investment;
use App\Models\MonthlyFinance;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Native\Laravel\Facades\Notification;

class FinanceDashboard extends Component
{
    // Authentication state
    public bool $isAuthenticated = false;

    public string $passwordInput = '';

    // Privacy mode (hides sensitive values)
    public bool $hideValues = false;

    // Active Screen: 'dashboard', 'meses', 'detalhes', 'caixinhas', 'investimentos'
    public string $currentScreen = 'dashboard';

    // List of monthly records
    public array $finances = [];

    // List of Caixinhas
    public array $caixinhas = [];

    // List of Investments
    public array $investments = [];

    // Global settings state
    public float $bolsa_auxilio = 1000.00;

    public float $alimentacao_dia = 20.00;

    public float $transporte_dia = 15.00;

    public float $dinheiro_mae = 100.00;

    public float $internet_padrao = 100.00;

    public float $gemini_padrao = 100.00;

    // Modal state controllers
    public bool $showFormModal = false;

    public bool $showSettingsModal = false;

    public bool $showCaixinhaModal = false;

    public bool $showDepositModal = false;

    public bool $showInvestmentModal = false;

    // Form fields for monthly finance create/edit
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

    // Extra column & toggles
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

    // Automatic calculation preview in modal
    public float $previewSalarioTeorico = 0.0;

    public float $previewMae = 0.0;

    public float $previewSaldoFinal = 0.0;

    // Caixinha form fields
    public ?int $caixinhaId = null;

    public string $caixinhaName = '';

    public ?float $caixinhaTarget = null;

    public float $caixinhaBalance = 0.0;

    public string $caixinhaColor = 'indigo';

    public string $caixinhaDescription = '';

    // Deposit/Withdraw Modal fields
    public ?int $selectedCaixinhaId = null;

    public float $depositAmount = 0.0;

    public string $depositActionType = 'deposito'; // 'deposito' ou 'resgate'

    // Investment form fields
    public ?int $investmentId = null;

    public string $investmentName = '';

    public string $investmentCategory = 'Renda Fixa';

    public string $investmentInstitution = '';

    public float $investmentAmount = 0.0;

    public string $investmentNotes = '';

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

    public function mount(): void
    {
        $this->isAuthenticated = session()->has('authenticated');
        $this->hideValues = (bool) session()->get('hide_values', false);

        $this->loadSettings();
        $this->loadFinances();
        $this->loadCaixinhas();
        $this->loadInvestments();

        // Defaults for form
        $this->year = (int) date('Y');
        $this->month = (int) date('n');
    }

    public function togglePrivacy(): void
    {
        $this->hideValues = ! $this->hideValues;
        session()->put('hide_values', $this->hideValues);
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
        $this->internet_padrao = (float) Setting::getValue('internet_padrao', 100.00);
        $this->gemini_padrao = (float) Setting::getValue('gemini_padrao', 100.00);
    }

    public function loadFinances(): void
    {
        $this->finances = MonthlyFinance::orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->all();
    }

    public function loadCaixinhas(): void
    {
        $this->caixinhas = Caixinha::orderBy('created_at', 'desc')->get()->all();
    }

    public function loadInvestments(): void
    {
        $this->investments = Investment::orderBy('amount', 'desc')->get()->all();
    }

    public function saveSettings(): void
    {
        $this->validate([
            'bolsa_auxilio' => 'required|numeric|min:0',
            'alimentacao_dia' => 'required|numeric|min:0',
            'transporte_dia' => 'required|numeric|min:0',
            'dinheiro_mae' => 'required|numeric|min:0',
            'internet_padrao' => 'required|numeric|min:0',
            'gemini_padrao' => 'required|numeric|min:0',
        ]);

        Setting::setValue('bolsa_auxilio', $this->bolsa_auxilio);
        Setting::setValue('alimentacao_dia', $this->alimentacao_dia);
        Setting::setValue('transporte_dia', $this->transporte_dia);
        Setting::setValue('dinheiro_mae', $this->dinheiro_mae);
        Setting::setValue('internet_padrao', $this->internet_padrao);
        Setting::setValue('gemini_padrao', $this->gemini_padrao);

        $this->notify('Configurações globais salvas com sucesso!');

        $this->loadFinances();
        $this->showSettingsModal = false;
    }

    public function openSettingsModal(): void
    {
        $this->showSettingsModal = true;
    }

    public function openCreateModal(): void
    {
        $this->resetErrorBag();
        $this->editingId = null;
        $this->formTab = 'basico';

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

        // Reset toggles and extra columns to defaults
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
        $this->internet = (float) $finance->internet;
        $this->gemini = (float) $finance->gemini;
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

        $this->previewSalarioTeorico = $finance->salario_teorico;
        $this->previewMae = $finance->total_mae;
        $this->previewSaldoFinal = $finance->saldo_final;

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

        // Use global values for new records
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

    public function setScreen(string $screen): void
    {
        $this->currentScreen = $screen;
        if ($screen !== 'detalhes') {
            $this->editingId = null;
        }
        if ($screen === 'caixinhas') {
            $this->loadCaixinhas();
        }
        if ($screen === 'investimentos') {
            $this->loadInvestments();
        }
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

    // ==========================================
    // CAIXINHAS ACTIONS
    // ==========================================

    public function openCreateCaixinhaModal(): void
    {
        $this->resetErrorBag();
        $this->caixinhaId = null;
        $this->caixinhaName = '';
        $this->caixinhaTarget = null;
        $this->caixinhaBalance = 0.0;
        $this->caixinhaColor = 'indigo';
        $this->caixinhaDescription = '';
        $this->showCaixinhaModal = true;
    }

    public function openEditCaixinhaModal(int $id): void
    {
        $this->resetErrorBag();
        $c = Caixinha::findOrFail($id);
        $this->caixinhaId = $c->id;
        $this->caixinhaName = $c->name;
        $this->caixinhaTarget = $c->target_amount;
        $this->caixinhaBalance = (float) $c->balance;
        $this->caixinhaColor = $c->color ?? 'indigo';
        $this->caixinhaDescription = $c->description ?? '';
        $this->showCaixinhaModal = true;
    }

    public function saveCaixinha(): void
    {
        $this->validate([
            'caixinhaName' => 'required|string|max:100',
            'caixinhaTarget' => 'nullable|numeric|min:0',
            'caixinhaBalance' => 'required|numeric|min:0',
            'caixinhaColor' => 'required|string',
            'caixinhaDescription' => 'nullable|string|max:255',
        ]);

        if ($this->caixinhaId) {
            $c = Caixinha::findOrFail($this->caixinhaId);
            $c->update([
                'name' => $this->caixinhaName,
                'target_amount' => $this->caixinhaTarget > 0 ? $this->caixinhaTarget : null,
                'balance' => $this->caixinhaBalance,
                'color' => $this->caixinhaColor,
                'description' => $this->caixinhaDescription,
            ]);
            $this->notify('Caixinha atualizada com sucesso!');
        } else {
            Caixinha::create([
                'name' => $this->caixinhaName,
                'target_amount' => $this->caixinhaTarget > 0 ? $this->caixinhaTarget : null,
                'balance' => $this->caixinhaBalance,
                'color' => $this->caixinhaColor,
                'description' => $this->caixinhaDescription,
            ]);
            $this->notify('Caixinha criada com sucesso!');
        }

        $this->showCaixinhaModal = false;
        $this->loadCaixinhas();
    }

    public function openDepositModal(int $id, string $type = 'deposito'): void
    {
        $this->resetErrorBag();
        $this->selectedCaixinhaId = $id;
        $this->depositAmount = 0.0;
        $this->depositActionType = $type;
        $this->showDepositModal = true;
    }

    public function processDepositAction(): void
    {
        $this->validate([
            'depositAmount' => 'required|numeric|min:0.01',
        ]);

        if (! $this->selectedCaixinhaId) {
            return;
        }

        $caixinha = Caixinha::findOrFail($this->selectedCaixinhaId);

        if ($this->depositActionType === 'deposito') {
            $caixinha->balance += $this->depositAmount;
            $msg = 'Depósito de R$ '.number_format($this->depositAmount, 2, ',', '.').' realizado com sucesso!';
        } else {
            if ($caixinha->balance < $this->depositAmount) {
                $this->addError('depositAmount', 'Saldo insuficiente nesta caixinha.');

                return;
            }
            $caixinha->balance -= $this->depositAmount;
            $msg = 'Resgate de R$ '.number_format($this->depositAmount, 2, ',', '.').' realizado com sucesso!';
        }

        $caixinha->save();
        $this->showDepositModal = false;
        $this->loadCaixinhas();
        $this->notify($msg);
    }

    public function quickDeposit(int $id, float $amount): void
    {
        $caixinha = Caixinha::findOrFail($id);
        $caixinha->balance += $amount;
        $caixinha->save();
        $this->loadCaixinhas();
        $this->notify('+ R$ '.number_format($amount, 2, ',', '.').' guardado em '.$caixinha->name.'!');
    }

    public function deleteCaixinha(int $id): void
    {
        $caixinha = Caixinha::findOrFail($id);
        $caixinha->delete();
        $this->loadCaixinhas();
        $this->notify('Caixinha excluída com sucesso!');
    }

    // ==========================================
    // INVESTMENTS ACTIONS
    // ==========================================

    public function openCreateInvestmentModal(): void
    {
        $this->resetErrorBag();
        $this->investmentId = null;
        $this->investmentName = '';
        $this->investmentCategory = 'Renda Fixa';
        $this->investmentInstitution = '';
        $this->investmentAmount = 0.0;
        $this->investmentNotes = '';
        $this->showInvestmentModal = true;
    }

    public function openEditInvestmentModal(int $id): void
    {
        $this->resetErrorBag();
        $inv = Investment::findOrFail($id);
        $this->investmentId = $inv->id;
        $this->investmentName = $inv->name;
        $this->investmentCategory = $inv->category;
        $this->investmentInstitution = $inv->institution ?? '';
        $this->investmentAmount = (float) $inv->amount;
        $this->investmentNotes = $inv->notes ?? '';
        $this->showInvestmentModal = true;
    }

    public function saveInvestment(): void
    {
        $this->validate([
            'investmentName' => 'required|string|max:100',
            'investmentCategory' => 'required|string',
            'investmentInstitution' => 'nullable|string|max:100',
            'investmentAmount' => 'required|numeric|min:0',
            'investmentNotes' => 'nullable|string|max:255',
        ]);

        if ($this->investmentId) {
            $inv = Investment::findOrFail($this->investmentId);
            $inv->update([
                'name' => $this->investmentName,
                'category' => $this->investmentCategory,
                'institution' => $this->investmentInstitution,
                'amount' => $this->investmentAmount,
                'notes' => $this->investmentNotes,
            ]);
            $this->notify('Investimento atualizado com sucesso!');
        } else {
            Investment::create([
                'name' => $this->investmentName,
                'category' => $this->investmentCategory,
                'institution' => $this->investmentInstitution,
                'amount' => $this->investmentAmount,
                'notes' => $this->investmentNotes,
            ]);
            $this->notify('Investimento cadastrado com sucesso!');
        }

        $this->showInvestmentModal = false;
        $this->loadInvestments();
    }

    public function deleteInvestment(int $id): void
    {
        $inv = Investment::findOrFail($id);
        $inv->delete();
        $this->loadInvestments();
        $this->notify('Investimento excluído com sucesso!');
    }

    // ==========================================
    // TOTALS & CHARTS HELPERS
    // ==========================================

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
        return collect($this->finances)->map(function ($f) {
            return $f->month_name.' / '.$f->year;
        })->toArray();
    }

    public function getChartRecebido(): array
    {
        return collect($this->finances)->map(function ($f) {
            return (float) $f->recebido;
        })->toArray();
    }

    public function getChartSobrou(): array
    {
        return collect($this->finances)->map(function ($f) {
            return (float) $f->saldo_final;
        })->toArray();
    }

    public function getChartTotalCaxinha(): float
    {
        return (float) collect($this->finances)->sum('caxinha');
    }

    public function getChartTotalInvestimento(): float
    {
        return (float) collect($this->finances)->sum('investimento');
    }

    public function getChartTotalFatura(): float
    {
        return (float) collect($this->finances)->sum('fatura');
    }

    public function getChartTotalInternet(): float
    {
        return (float) collect($this->finances)->sum('internet');
    }

    public function getChartTotalGemini(): float
    {
        return (float) collect($this->finances)->sum('gemini');
    }

    public function getChartTotalMae(): float
    {
        return (float) collect($this->finances)->sum('total_mae');
    }

    private function notify(string $message): void
    {
        try {
            Notification::title('FinDesk')
                ->message($message)
                ->show();
        } catch (\Throwable $e) {
            // Silently ignore if not in nativephp
        }

        $this->dispatch('notify', ['message' => $message]);
    }

    public function render(): View
    {
        return view('livewire.finance-dashboard')
            ->layout('components.layouts.app');
    }
}
