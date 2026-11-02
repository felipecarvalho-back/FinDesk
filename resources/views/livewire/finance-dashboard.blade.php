<div class="flex-1 flex flex-col h-full bg-slate-950 text-slate-100 select-none overflow-y-auto">
    @if(! $isAuthenticated)
        @include('livewire.finance.login')
    @else
        <div wire:key="authenticated-app-wrapper" class="flex-1 flex flex-col min-h-0 w-full relative">
            @include('livewire.finance.header')

            <!-- Main Workspace Content -->
            <div class="flex-1 p-6 space-y-6 max-w-7xl mx-auto w-full">
                @include('livewire.finance.screens.dashboard')
                @include('livewire.finance.screens.meses')
                @include('livewire.finance.screens.detalhes')
                @include('livewire.finance.screens.caixinhas')
                @include('livewire.finance.screens.investimentos')
            </div>

            <!-- Modals -->
            @include('livewire.finance.modals.month-form')
            @include('livewire.finance.modals.settings-modal')
            @include('livewire.finance.modals.caixinha-form')
            @include('livewire.finance.modals.deposit-modal')
            @include('livewire.finance.modals.investment-form')
        </div>
    @endif
</div>
