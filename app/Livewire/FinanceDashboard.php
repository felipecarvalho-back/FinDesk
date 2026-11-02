<?php

namespace App\Livewire;

use App\Livewire\Concerns\ManagesCaixinhas;
use App\Livewire\Concerns\ManagesInvestments;
use App\Livewire\Concerns\ManagesMonthlyFinances;
use App\Livewire\Concerns\ManagesSettings;
use App\Livewire\Concerns\ProvidesChartData;
use App\Models\Caixinha;
use App\Models\Investment;
use App\Models\MonthlyFinance;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Native\Laravel\Facades\Notification;

/**
 * @property-read Collection<int, MonthlyFinance> $finances
 * @property-read Collection<int, Caixinha> $caixinhas
 * @property-read Collection<int, Investment> $investments
 */
class FinanceDashboard extends Component
{
    use ManagesCaixinhas;
    use ManagesInvestments;
    use ManagesMonthlyFinances;
    use ManagesSettings;
    use ProvidesChartData;

    public bool $isAuthenticated = false;

    public string $passwordInput = '';

    public bool $hideValues = false;

    public string $currentScreen = 'dashboard';

    public function mount(): void
    {
        $this->isAuthenticated = session()->has('authenticated');
        $this->hideValues = (bool) session()->get('hide_values', false);

        $this->loadSettings();

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

    /**
     * @return Collection<int, MonthlyFinance>
     */
    #[Computed]
    public function finances()
    {
        return MonthlyFinance::orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    /**
     * @return Collection<int, Caixinha>
     */
    #[Computed]
    public function caixinhas()
    {
        return Caixinha::orderBy('created_at', 'desc')->get();
    }

    /**
     * @return Collection<int, Investment>
     */
    #[Computed]
    public function investments()
    {
        return Investment::orderBy('amount', 'desc')->get();
    }

    public function loadFinances(): void
    {
        unset($this->finances);
    }

    public function loadCaixinhas(): void
    {
        unset($this->caixinhas);
    }

    public function loadInvestments(): void
    {
        unset($this->investments);
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
        return view('livewire.finance-dashboard', [
            'finances' => $this->finances,
            'caixinhas' => $this->caixinhas,
            'investments' => $this->investments,
        ])->layout('components.layouts.app');
    }
}
