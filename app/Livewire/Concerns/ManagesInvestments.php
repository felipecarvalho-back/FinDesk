<?php

namespace App\Livewire\Concerns;

use App\Models\Investment;

trait ManagesInvestments
{
    public bool $showInvestmentModal = false;

    public ?int $investmentId = null;

    public string $investmentName = '';

    public string $investmentCategory = 'Renda Fixa';

    public string $investmentInstitution = '';

    public float $investmentAmount = 0.0;

    public string $investmentNotes = '';

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
}
