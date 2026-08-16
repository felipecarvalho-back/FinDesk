<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Native\Desktop\Facades\Window;

#[Title('Valores Globais Padrão - FinDesk')]
#[Layout('components.layouts.app')]
class GlobalSettings extends Component
{
    public float $bolsa_auxilio = 1000.00;

    public float $alimentacao_dia = 20.00;

    public float $transporte_dia = 15.00;

    public float $dinheiro_mae = 100.00;

    public float $internet_padrao = 100.00;

    public float $gemini_padrao = 100.00;

    public bool $saved = false;

    public function mount(): void
    {
        $this->bolsa_auxilio = (float) Setting::getValue('bolsa_auxilio', 1000.00);
        $this->alimentacao_dia = (float) Setting::getValue('alimentacao_dia', 20.00);
        $this->transporte_dia = (float) Setting::getValue('transporte_dia', 15.00);
        $this->dinheiro_mae = (float) Setting::getValue('dinheiro_mae', 100.00);
        $this->internet_padrao = (float) Setting::getValue('internet_padrao', 100.00);
        $this->gemini_padrao = (float) Setting::getValue('gemini_padrao', 100.00);
    }

    public function save(): void
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

        $this->saved = true;
        $this->dispatch('settings-updated');
    }

    public function closeWindow(): void
    {
        if (class_exists(Window::class)) {
            try {
                Window::close('settings');

                return;
            } catch (\Throwable $e) {
                // Silently ignore if outside Electron shell
            }
        }

        $this->redirectRoute('home');
    }

    public function render()
    {
        return view('livewire.global-settings');
    }
}
