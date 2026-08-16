<?php

use App\Livewire\GlobalSettings;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('global settings page renders and loads saved settings', function () {
    Setting::setValue('bolsa_auxilio', 1200.00);
    Setting::setValue('alimentacao_dia', 25.00);
    Setting::setValue('transporte_dia', 18.50);
    Setting::setValue('dinheiro_mae', 150.00);
    Setting::setValue('internet_padrao', 110.00);
    Setting::setValue('gemini_padrao', 90.00);

    Livewire::test(GlobalSettings::class)
        ->assertSet('bolsa_auxilio', 1200.00)
        ->assertSet('alimentacao_dia', 25.00)
        ->assertSet('transporte_dia', 18.50)
        ->assertSet('dinheiro_mae', 150.00)
        ->assertSet('internet_padrao', 110.00)
        ->assertSet('gemini_padrao', 90.00)
        ->assertSee('Valores Globais Padrão');
});

test('global settings can be updated from component', function () {
    Livewire::test(GlobalSettings::class)
        ->set('bolsa_auxilio', 1500.00)
        ->set('alimentacao_dia', 30.00)
        ->set('transporte_dia', 20.00)
        ->set('dinheiro_mae', 200.00)
        ->set('internet_padrao', 130.00)
        ->set('gemini_padrao', 100.00)
        ->call('save')
        ->assertDispatched('settings-updated')
        ->assertHasNoErrors();

    expect(Setting::getValue('bolsa_auxilio'))->toBe('1500');
    expect(Setting::getValue('alimentacao_dia'))->toBe('30');
    expect(Setting::getValue('dinheiro_mae'))->toBe('200');
});
