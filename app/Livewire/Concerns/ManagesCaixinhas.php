<?php

namespace App\Livewire\Concerns;

use App\Models\Caixinha;

trait ManagesCaixinhas
{
    public bool $showCaixinhaModal = false;

    public bool $showDepositModal = false;

    public ?int $caixinhaId = null;

    public string $caixinhaName = '';

    public ?float $caixinhaTarget = null;

    public float $caixinhaBalance = 0.0;

    public string $caixinhaColor = 'indigo';

    public string $caixinhaDescription = '';

    public ?int $selectedCaixinhaId = null;

    public float $depositAmount = 0.0;

    public string $depositActionType = 'deposito';

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
}
