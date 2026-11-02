<?php

use App\Livewire\FinanceDashboard;
use App\Models\Caixinha;
use App\Models\Investment;
use App\Models\MonthlyFinance;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('global settings can be set and retrieved including internet and gemini', function () {
    Setting::setValue('bolsa_auxilio', 937.59);
    Setting::setValue('internet_padrao', 120.00);
    Setting::setValue('gemini_padrao', 96.00);

    expect(Setting::getValue('bolsa_auxilio'))->toBe('937.59');
    expect(Setting::getValue('internet_padrao'))->toBe('120');
    expect(Setting::getValue('gemini_padrao'))->toBe('96');
});

test('monthly finance correctly calculates salary, mother payment, internet, gemini, and remaining balance', function () {
    // Seed settings
    Setting::setValue('bolsa_auxilio', 937.59);
    Setting::setValue('alimentacao_dia', 12.00);
    Setting::setValue('transporte_dia', 19.85);
    Setting::setValue('dinheiro_mae', 150.00);

    // Create June record
    $finance = MonthlyFinance::create([
        'year' => 2026,
        'month' => 6, // June
        'dias_trabalhados' => 19,
        'conducao_dia' => 12.10,
        'dias_conducao' => 16,
        'recebido' => 1600.00,
        'caxinha' => 300.00,
        'investimento' => 200.00,
        'fatura' => 300.00,
        'internet' => 100.00,
        'gemini' => 100.00,
        'bolsa_auxilio_snapshot' => (float) Setting::getValue('bolsa_auxilio'),
        'alimentacao_dia_snapshot' => (float) Setting::getValue('alimentacao_dia'),
        'transporte_dia_snapshot' => (float) Setting::getValue('transporte_dia'),
        'dinheiro_mae_snapshot' => (float) Setting::getValue('dinheiro_mae'),
    ]);

    // Assert June formulas
    expect($finance->salario_teorico)->toBe(1542.74);
    expect($finance->total_mae)->toBe(343.60);
    // saldo_final = 1600 - 343.60 - 300 - 200 - 300 - 100 - 100 = 256.40
    expect($finance->saldo_final)->toBe(256.40);
    expect($finance->month_name)->toBe('Junho');
    expect($finance->receiving_month_name)->toBe('Julho');
});

test('livewire dashboard component can load, calculate, and save data with internet and gemini', function () {
    Setting::setValue('bolsa_auxilio', 937.59);
    Setting::setValue('alimentacao_dia', 12.00);
    Setting::setValue('transporte_dia', 19.85);
    Setting::setValue('dinheiro_mae', 150.00);
    Setting::setValue('internet_padrao', 100.00);
    Setting::setValue('gemini_padrao', 100.00);

    Livewire::test(FinanceDashboard::class)
        ->set('isAuthenticated', true)
        ->assertSet('bolsa_auxilio', 937.59)
        ->call('openCreateModal')
        ->assertSet('formTab', 'basico')
        ->set('year', 2026)
        ->set('month', 6)
        ->set('dias_trabalhados', 19)
        ->set('dias_conducao', 16)
        ->set('conducao_dia', 12.10)
        ->set('recebido', 1600.00)
        ->set('caxinha', 300.00)
        ->set('investimento', 200.00)
        ->set('fatura', 300.00)
        ->set('internet', 100.00)
        ->set('gemini', 100.00)
        ->assertSet('previewSalarioTeorico', 1542.74)
        ->assertSet('previewMae', 343.60)
        ->assertSet('previewSaldoFinal', 256.40)
        ->call('saveFinance')
        ->assertHasNoErrors();

    $finance = MonthlyFinance::where('year', 2026)->where('month', 6)->first();
    expect($finance)->not->toBeNull();
    expect($finance->salario_teorico)->toBe(1542.74);
    expect($finance->total_mae)->toBe(343.60);
    expect($finance->saldo_final)->toBe(256.40);
});

test('monthly finance calculations with ignored internet and gemini', function () {
    Setting::setValue('bolsa_auxilio', 1000.00);
    Setting::setValue('alimentacao_dia', 20.00);
    Setting::setValue('transporte_dia', 15.00);
    Setting::setValue('dinheiro_mae', 100.00);

    $finance = MonthlyFinance::create([
        'year' => 2026,
        'month' => 6,
        'dias_trabalhados' => 20,
        'conducao_dia' => 10.00,
        'dias_conducao' => 20,
        'recebido' => 1500.00,
        'caxinha' => 300.00,
        'investimento' => 200.00,
        'fatura' => 300.00,
        'internet' => 100.00,
        'gemini' => 100.00,
        'bolsa_auxilio_snapshot' => (float) Setting::getValue('bolsa_auxilio'),
        'alimentacao_dia_snapshot' => (float) Setting::getValue('alimentacao_dia'),
        'transporte_dia_snapshot' => (float) Setting::getValue('transporte_dia'),
        'dinheiro_mae_snapshot' => (float) Setting::getValue('dinheiro_mae'),
        'ignorar_internet' => true,
        'ignorar_gemini' => true,
    ]);

    // total_mae = 100 + 200 = 300
    // saldo_final = 1500 - 300 - 300 - 200 - 300 - 0 (internet ignored) - 0 (gemini ignored) = 400.00
    expect($finance->saldo_final)->toBe(400.00);
});

test('caixinhas can be created, deposited, and balance updated', function () {
    $caixinha = Caixinha::create([
        'name' => 'Reserva de Emergência',
        'target_amount' => 5000.00,
        'balance' => 1000.00,
        'color' => 'indigo',
        'description' => 'Para imprevistos',
    ]);

    expect($caixinha->progress_percentage)->toBe(20.0);

    Livewire::test(FinanceDashboard::class)
        ->set('isAuthenticated', true)
        ->call('setScreen', 'caixinhas')
        ->call('quickDeposit', $caixinha->id, 50.00);

    $caixinha->refresh();
    expect($caixinha->balance)->toBe(1050.00);

    Livewire::test(FinanceDashboard::class)
        ->set('isAuthenticated', true)
        ->set('selectedCaixinhaId', $caixinha->id)
        ->set('depositActionType', 'deposito')
        ->set('depositAmount', 200.00)
        ->call('processDepositAction');

    $caixinha->refresh();
    expect($caixinha->balance)->toBe(1250.00);
});

test('investments can be created, updated, and listed', function () {
    $inv = Investment::create([
        'name' => 'CDB Banco Inter 100% CDI',
        'category' => 'Renda Fixa',
        'institution' => 'Banco Inter',
        'amount' => 3500.00,
        'notes' => 'Liquidez diária',
    ]);

    expect($inv->amount)->toBe(3500.00);

    Livewire::test(FinanceDashboard::class)
        ->set('isAuthenticated', true)
        ->call('setScreen', 'investimentos')
        ->set('investmentId', $inv->id)
        ->set('investmentName', 'CDB Banco Inter 100% CDI')
        ->set('investmentCategory', 'Renda Fixa')
        ->set('investmentAmount', 4000.00)
        ->call('saveInvestment')
        ->assertHasNoErrors();

    $inv->refresh();
    expect($inv->amount)->toBe(4000.00);
});

test('privacy mode toggles state', function () {
    Livewire::test(FinanceDashboard::class)
        ->set('isAuthenticated', true)
        ->assertSet('hideValues', false)
        ->call('togglePrivacy')
        ->assertSet('hideValues', true)
        ->call('togglePrivacy')
        ->assertSet('hideValues', false);
});

test('computed collections load and render without serializing heavy public arrays', function () {
    Caixinha::create([
        'name' => 'Viagem',
        'target_amount' => 2000.00,
        'balance' => 500.00,
        'color' => 'blue',
    ]);

    Investment::create([
        'name' => 'Tesouro Selic 2029',
        'category' => 'Renda Fixa',
        'institution' => 'Tesouro Direto',
        'amount' => 1500.00,
    ]);

    $component = Livewire::test(FinanceDashboard::class)
        ->set('isAuthenticated', true)
        ->assertViewHas('finances')
        ->assertViewHas('caixinhas')
        ->assertViewHas('investments');

    expect($component->instance()->caixinhas->count())->toBe(1);
    expect($component->instance()->investments->count())->toBe(1);
    expect($component->instance()->getTotalCaixinhasBalance())->toBe(500.00);
    expect($component->instance()->getTotalInvestmentsAmount())->toBe(1500.00);
});
