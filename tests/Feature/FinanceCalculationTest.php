<?php

use App\Models\Setting;
use App\Models\MonthlyFinance;
use App\Livewire\FinanceDashboard;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
