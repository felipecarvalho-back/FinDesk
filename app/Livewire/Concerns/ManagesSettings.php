<?php

namespace App\Livewire\Concerns;

use App\Models\Setting;
use Livewire\Attributes\On;
use Native\Desktop\Facades\Window;

trait ManagesSettings
{
    public float $bolsa_auxilio = 1000.00;

    public float $alimentacao_dia = 20.00;

    public float $transporte_dia = 15.00;

    public float $dinheiro_mae = 100.00;

    public float $internet_padrao = 100.00;

    public float $gemini_padrao = 100.00;

    public bool $showSettingsModal = false;

    public function loadSettings(): void
    {
        $this->bolsa_auxilio = (float) Setting::getValue('bolsa_auxilio', 1000.00);
        $this->alimentacao_dia = (float) Setting::getValue('alimentacao_dia', 20.00);
        $this->transporte_dia = (float) Setting::getValue('transporte_dia', 15.00);
        $this->dinheiro_mae = (float) Setting::getValue('dinheiro_mae', 100.00);
        $this->internet_padrao = (float) Setting::getValue('internet_padrao', 100.00);
        $this->gemini_padrao = (float) Setting::getValue('gemini_padrao', 100.00);
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

    #[On('settings-updated')]
    public function refreshGlobalSettings(): void
    {
        $this->loadSettings();
        $this->loadFinances();
    }

    public function openSettingsModal(): void
    {
        if (class_exists(Window::class)) {
            try {
                Window::open('settings')
                    ->route('settings')
                    ->width(480)
                    ->height(540)
                    ->minWidth(450)
                    ->minHeight(500)
                    ->maxWidth(550)
                    ->maxHeight(600)
                    ->resizable(false)
                    ->title('Valores Globais Padrão')
                    ->alwaysOnTop()
                    ->showDevTools(false)
                    ->hideMenu();

                return;
            } catch (\Throwable $e) {
                // Fallback para modal in-app no navegador
            }
        }

        $this->showSettingsModal = true;
    }
}
