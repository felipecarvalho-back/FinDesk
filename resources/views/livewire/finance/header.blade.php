<!-- Top Header Navigation -->
<header class="sticky top-0 z-20 bg-slate-900/90 backdrop-blur-md border-b border-slate-800/80 px-6 py-3.5 flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center space-x-3">
        <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-md shadow-indigo-500/20">
            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-base font-bold tracking-tight text-white">FinDesk</h1>
                <span class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-md bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Desktop</span>
            </div>
            <p class="text-xs text-slate-400">Gerenciador de Finanças Pessoais</p>
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <!-- Screen Selection Tabs -->
        <div class="flex items-center bg-slate-950/90 p-1 rounded-xl border border-slate-800/80 shadow-inner space-x-1">
            <button type="button" wire:click="setScreen('dashboard')"
                class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-150 {{ $currentScreen === 'dashboard' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                <svg class="h-3.5 w-3.5 {{ $currentScreen === 'dashboard' ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Painel Geral</span>
            </button>
            <button type="button" wire:click="setScreen('meses')"
                class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-150 {{ $currentScreen === 'meses' || $currentScreen === 'detalhes' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                <svg class="h-3.5 w-3.5 {{ $currentScreen === 'meses' || $currentScreen === 'detalhes' ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Meus Meses</span>
            </button>
            <button type="button" wire:click="setScreen('caixinhas')"
                class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-150 {{ $currentScreen === 'caixinhas' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                <svg class="h-3.5 w-3.5 {{ $currentScreen === 'caixinhas' ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>Caixinhas</span>
            </button>
            <button type="button" wire:click="setScreen('investimentos')"
                class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-150 {{ $currentScreen === 'investimentos' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                <svg class="h-3.5 w-3.5 {{ $currentScreen === 'investimentos' ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <span>Investimentos</span>
            </button>
        </div>

        <!-- Global Variables Quick View Badge -->
        <div class="hidden 2xl:flex items-center space-x-3 bg-slate-950/80 border border-slate-800/90 rounded-xl px-3.5 py-1.5 text-xs text-slate-400 select-none shadow-inner">
            <div class="flex items-center space-x-1.5">
                <span class="text-slate-500 font-medium">Bolsa:</span>
                <span class="font-bold text-slate-200 whitespace-nowrap">
                    {{ $hideValues ? '••••' : 'R$ ' . number_format($bolsa_auxilio, 2, ',', '.') }}
                </span>
            </div>
            <div class="border-l border-slate-800 h-3.5"></div>
            <div class="flex items-center space-x-1.5">
                <span class="text-slate-500 font-medium">VR/dia:</span>
                <span class="font-bold text-slate-200 whitespace-nowrap">
                    {{ $hideValues ? '••••' : 'R$ ' . number_format($alimentacao_dia, 2, ',', '.') }}
                </span>
            </div>
            <div class="border-l border-slate-800 h-3.5"></div>
            <div class="flex items-center space-x-1.5">
                <span class="text-slate-500 font-medium">Net/mês:</span>
                <span class="font-bold text-slate-200 whitespace-nowrap">
                    {{ $hideValues ? '••••' : 'R$ ' . number_format($internet_padrao, 2, ',', '.') }}
                </span>
            </div>
            <div class="border-l border-slate-800 h-3.5"></div>
            <div class="flex items-center space-x-1.5">
                <span class="text-slate-500 font-medium">Gemini/mês:</span>
                <span class="font-bold text-slate-200 whitespace-nowrap">
                    {{ $hideValues ? '••••' : 'R$ ' . number_format($gemini_padrao, 2, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Privacy Toggle Button --}}
        <button type="button" wire:click="togglePrivacy"
            title="{{ $hideValues ? 'Mostrar valores' : 'Ocultar valores sensíveis' }}"
            @class([
                'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all duration-150',
                'bg-amber-500/15 text-amber-400' => $hideValues,
                'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' => !$hideValues,
            ])>
            @if($hideValues)
                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                </svg>
                <span class="hidden sm:inline">Oculto</span>
            @else
                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span class="hidden sm:inline">Ocultar</span>
            @endif
        </button>

        {{-- Divider --}}
        <div class="h-4 w-px bg-slate-800"></div>

        {{-- Globais Button --}}
        <button type="button" wire:click="openSettingsModal"
            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-400 hover:text-slate-200 hover:bg-slate-900/60 transition-all duration-150">
            <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="hidden sm:inline">Globais</span>
        </button>

    </div>
</header>
