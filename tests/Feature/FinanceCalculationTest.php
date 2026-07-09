<?php

use App\Livewire\FinanceDashboard;
use App\Models\MonthlyFinance;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('global settings can be set and retrieved', function () {
    Setting::setValue('bolsa_auxilio', 937.59);
    expect(Setting::getValue('bolsa_auxilio'))->toBe('937.59');

    Setting::setValue('bolsa_auxilio', 1000.00);
    expect(Setting::getValue('bolsa_auxilio'))->toBe('1000');
});

test('monthly finance correctly calculates salary, mother payment, and remaining balance', function () {
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
        'bolsa_auxilio_snapshot' => (float) Setting::getValue('bolsa_auxilio'),
        'alimentacao_dia_snapshot' => (float) Setting::getValue('alimentacao_dia'),
        'transporte_dia_snapshot' => (float) Setting::getValue('transporte_dia'),
        'dinheiro_mae_snapshot' => (float) Setting::getValue('dinheiro_mae'),
    ]);

    // Assert June formulas based on user spreadsheet image
    expect($finance->salario_teorico)->toBe(1542.74);
    expect($finance->total_mae)->toBe(343.60);
    expect($finance->saldo_final)->toBe(456.40);
    expect($finance->month_name)->toBe('Junho');
    expect($finance->receiving_month_name)->toBe('Julho');
});

test('livewire dashboard component can load, calculate, and save data', function () {
    // Seed test settings explicitly
    Setting::setValue('bolsa_auxilio', 937.59);
    Setting::setValue('alimentacao_dia', 12.00);
    Setting::setValue('transporte_dia', 19.85);
    Setting::setValue('dinheiro_mae', 150.00);

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
        ->assertSet('previewSalarioTeorico', 1542.74)
        ->assertSet('previewMae', 343.60)
        ->assertSet('previewSaldoFinal', 456.40)
        ->call('saveFinance')
        ->assertHasNoErrors();

    // Verify database entry
    $finance = MonthlyFinance::where('year', 2026)->where('month', 6)->first();
    expect($finance)->not->toBeNull();
    expect($finance->salario_teorico)->toBe(1542.74);
    expect($finance->total_mae)->toBe(343.60);
    expect($finance->saldo_final)->toBe(456.40);
});

test('user can log in with correct password', function () {
    Livewire::test(FinanceDashboard::class)
        ->assertSet('isAuthenticated', false)
        ->set('passwordInput', 'kiraFE22')
        ->call('login')
        ->assertSet('isAuthenticated', true)
        ->assertHasNoErrors();
});

test('user cannot log in with incorrect password', function () {
    Livewire::test(FinanceDashboard::class)
        ->assertSet('isAuthenticated', false)
        ->set('passwordInput', 'wrong_password')
        ->call('login')
        ->assertSet('isAuthenticated', false)
        ->assertHasErrors(['passwordInput']);
});

test('monthly finance calculations with ignored global variables and columns', function () {
    // Seed settings
    Setting::setValue('bolsa_auxilio', 1000.00);
    Setting::setValue('alimentacao_dia', 20.00);
    Setting::setValue('transporte_dia', 15.00);
    Setting::setValue('dinheiro_mae', 100.00);

    // Create record with ignored settings (ignore bolsa and caxinha)
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
        'bolsa_auxilio_snapshot' => (float) Setting::getValue('bolsa_auxilio'),
        'alimentacao_dia_snapshot' => (float) Setting::getValue('alimentacao_dia'),
        'transporte_dia_snapshot' => (float) Setting::getValue('transporte_dia'),
        'dinheiro_mae_snapshot' => (float) Setting::getValue('dinheiro_mae'),
        // Toggles
        'ignorar_bolsa' => true,
        'ignorar_caxinha' => true,
    ]);

    // salario_teorico = (bolsa ignored) 0 + (20 * 20) + (15 * 20) = 400 + 300 = 700.00
    expect($finance->salario_teorico)->toBe(700.00);
    // total_mae = 100 + (10 * 20) = 300.00
    expect($finance->total_mae)->toBe(300.00);
    // saldo_final = recebido - total_mae - (caxinha ignored) 0 - investimento - fatura = 1500 - 300 - 0 - 200 - 300 = 700.00
    expect($finance->saldo_final)->toBe(700.00);
});

test('monthly finance calculations with extra income/expense columns', function () {
    // Seed settings
    Setting::setValue('bolsa_auxilio', 1000.00);
    Setting::setValue('alimentacao_dia', 20.00);
    Setting::setValue('transporte_dia', 15.00);
    Setting::setValue('dinheiro_mae', 100.00);

    // Create record with extra income
    $financeIncome = MonthlyFinance::create([
        'year' => 2026,
        'month' => 6,
        'dias_trabalhados' => 20,
        'conducao_dia' => 10.00,
        'dias_conducao' => 20,
        'recebido' => 1500.00,
        'caxinha' => 300.00,
        'investimento' => 200.00,
        'fatura' => 300.00,
        'bolsa_auxilio_snapshot' => (float) Setting::getValue('bolsa_auxilio'),
        'alimentacao_dia_snapshot' => (float) Setting::getValue('alimentacao_dia'),
        'transporte_dia_snapshot' => (float) Setting::getValue('transporte_dia'),
        'dinheiro_mae_snapshot' => (float) Setting::getValue('dinheiro_mae'),
        // Extra income
        'extra_nome' => 'Bônus',
        'extra_valor' => 250.00,
        'extra_tipo' => 'entrada',
    ]);

    // total_mae = 100 + 200 = 300
    // saldo_final = recebido (1500) - total_mae (300) - caxinha (300) - investimento (200) - fatura (300) + extra (250) = 400 + 250 = 650.00
    expect($financeIncome->saldo_final)->toBe(650.00);

    // Create record with extra expense
    $financeExpense = MonthlyFinance::create([
        'year' => 2026,
        'month' => 7,
        'dias_trabalhados' => 20,
        'conducao_dia' => 10.00,
        'dias_conducao' => 20,
        'recebido' => 1500.00,
        'caxinha' => 300.00,
        'investimento' => 200.00,
        'fatura' => 300.00,
        'bolsa_auxilio_snapshot' => (float) Setting::getValue('bolsa_auxilio'),
        'alimentacao_dia_snapshot' => (float) Setting::getValue('alimentacao_dia'),
        'transporte_dia_snapshot' => (float) Setting::getValue('transporte_dia'),
        'dinheiro_mae_snapshot' => (float) Setting::getValue('dinheiro_mae'),
        // Extra expense
        'extra_nome' => 'Academia',
        'extra_valor' => 120.00,
        'extra_tipo' => 'saida',
    ]);

    // total_mae = 100 + 200 = 300
    // saldo_final = 1500 - 300 - 300 - 200 - 300 - 120 = 400 - 120 = 280.00
    expect($financeExpense->saldo_final)->toBe(280.00);
});
