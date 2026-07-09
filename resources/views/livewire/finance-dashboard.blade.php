<div class="flex-1 flex flex-col h-full bg-slate-950 text-slate-100 select-none overflow-y-auto">
    @if(!$isAuthenticated)
        <!-- Login Screen -->
        <div class="flex-1 flex flex-col justify-center items-center px-4 py-16 bg-slate-950">
            <div class="w-full max-w-sm bg-slate-900 border border-slate-800/80 p-8 rounded-2xl shadow-2xl text-center space-y-6">
                <!-- Icon -->
                <div class="mx-auto h-12 w-12 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <!-- Titles -->
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-100">Acesso ao FinDesk</h2>
                    <p class="text-xs text-slate-400 mt-1">Por favor, insira a senha para continuar</p>
                </div>
                <!-- Form -->
                <form wire:submit.prevent="login" class="space-y-4">
                    <div>
                        <input type="password" wire:model="passwordInput" placeholder="Senha" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 text-slate-100 text-center tracking-widest placeholder:tracking-normal text-sm" required autofocus>
                        @error('passwordInput') <span class="text-xs text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold rounded-xl text-sm transition-all duration-200 active:scale-[0.98] shadow-lg shadow-indigo-500/10">
                        Entrar
                    </button>
                </form>
            </div>
        </div>
    @else
        <!-- Top Header Navigation -->
        <header class="sticky top-0 z-10 bg-slate-900/80 backdrop-blur-md border-b border-slate-800/80 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="h-9 w-9 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight bg-gradient-to-r from-slate-100 to-slate-300 bg-clip-text text-transparent">FinDesk</h1>
                <p class="text-xs text-slate-400">Gerenciador de Finanças Pessoais Desktop</p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <!-- Global Variables Quick View Badge -->
            <div class="hidden lg:flex items-center space-x-4 bg-slate-950/60 border border-slate-800/60 rounded-lg px-4 py-2 text-xs text-slate-400">
                <div>
                    <span class="text-slate-500">Bolsa:</span>
                    <span class="font-semibold text-slate-300">R$ {{ number_format($bolsa_auxilio, 2, ',', '.') }}</span>
                </div>
                <div class="border-l border-slate-800 h-4"></div>
                <div>
                    <span class="text-slate-500">Alimentação/Dia:</span>
                    <span class="font-semibold text-slate-300">R$ {{ number_format($alimentacao_dia, 2, ',', '.') }}</span>
                </div>
                <div class="border-l border-slate-800 h-4"></div>
                <div>
                    <span class="text-slate-500">Transporte/Dia:</span>
                    <span class="font-semibold text-slate-300">R$ {{ number_format($transporte_dia, 2, ',', '.') }}</span>
                </div>
                <div class="border-l border-slate-800 h-4"></div>
                <div>
                    <span class="text-slate-500">Mãe Fixo:</span>
                    <span class="font-semibold text-slate-300">R$ {{ number_format($dinheiro_mae, 2, ',', '.') }}</span>
                </div>
            </div>

            <button wire:click="openSettingsModal" class="flex items-center space-x-2 bg-slate-900 border border-slate-800 hover:border-slate-700 active:bg-slate-950 hover:bg-slate-800 px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Ajustar Globais</span>
            </button>

            <button wire:click="openCreateModal" class="flex items-center space-x-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 active:scale-[0.98] shadow-md shadow-indigo-500/10 px-4 py-2 rounded-lg text-sm font-semibold text-white transition duration-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Adicionar Mês</span>
            </button>
        </div>
    </header>

    <!-- Main Workspace Content -->
    <div class="flex-1 p-6 space-y-6 max-w-7xl mx-auto w-full">
        <!-- Dashboard Summary Widget -->
        @if(count($finances) > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @php
                    $totalCaxinha = collect($finances)->sum('caxinha');
                    $totalInvestido = collect($finances)->sum('investimento');
                    $totalRecebido = collect($finances)->sum('recebido');
                    $totalSobrou = collect($finances)->sum('saldo_final');
                @endphp
                <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex items-center space-x-4">
                    <div class="h-10 w-10 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Total Recebido Geral</span>
                        <span class="text-xl font-bold text-slate-100">R$ {{ number_format($totalRecebido, 2, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex items-center space-x-4">
                    <div class="h-10 w-10 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Acumulado Caxinha</span>
                        <span class="text-xl font-bold text-slate-100">R$ {{ number_format($totalCaxinha, 2, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex items-center space-x-4">
                    <div class="h-10 w-10 rounded-lg bg-violet-500/10 flex items-center justify-center text-violet-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Total Investido</span>
                        <span class="text-xl font-bold text-slate-100">R$ {{ number_format($totalInvestido, 2, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 p-4 rounded-xl flex items-center space-x-4">
                    <div class="h-10 w-10 rounded-lg bg-teal-500/10 flex items-center justify-center text-teal-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 font-medium block">Saldo Livre Acumulado</span>
                        <span class="text-xl font-bold text-teal-400">R$ {{ number_format($totalSobrou, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Spreadsheet Horizontal Layout -->
        <div class="bg-slate-900/50 border border-slate-850 rounded-2xl p-6 shadow-xl relative overflow-x-auto min-h-[500px]">
            @if(count($finances) === 0)
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 space-y-4">
                    <div class="h-16 w-16 bg-slate-900 border border-slate-800 rounded-full flex items-center justify-center text-slate-500 shadow-inner">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-200">Nenhum mês registrado ainda</h3>
                        <p class="text-sm text-slate-400 mt-1">Configure os valores globais e adicione seu primeiro mês de trabalho.</p>
                    </div>
                    <button wire:click="openCreateModal" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-5 py-2 rounded-lg text-sm transition shadow-lg shadow-indigo-500/10">
                        Adicionar primeiro registro
                    </button>
                </div>
            @else
                <!-- The Spreadsheet Grid -->
                <div class="flex space-x-6 pb-4">
                    @foreach($finances as $finance)
                        <!-- Month Column Card -->
                        <div class="flex-none w-80 bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg transition duration-200 hover:border-slate-700">
                            <!-- Card Header (Month Name) -->
                            <div class="bg-slate-950 border-b border-slate-800 px-4 py-3 flex items-center justify-between">
                                <div>
                                    <h3 class="font-bold text-slate-200 text-base leading-tight">{{ $finance->month_name }}</h3>
                                    <span class="text-[10px] text-slate-500">Trab: {{ $finance->month }}/{{ $finance->year }} &rarr; Receb: {{ $finance->receiving_month_name }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <button wire:click="openEditModal({{ $finance->id }})" class="p-1.5 text-slate-400 hover:text-slate-200 hover:bg-slate-850 rounded transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-2.036a5 5 0 117.07 7.07l-9.341 9.341-4.172 1.086 1.086-4.172 9.341-9.341z" />
                                        </svg>
                                    </button>
                                    <button onclick="confirm('Tem certeza que deseja excluir?') || event.stopImmediatePropagation()" wire:click="deleteFinance({{ $finance->id }})" class="p-1.5 text-slate-500 hover:text-rose-400 hover:bg-slate-850 rounded transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Rows (Spreadsheet Layout) -->
                            <div class="divide-y divide-slate-800/60 text-sm">
                                <!-- Salario Teórico -->
                                <div class="px-4 py-2.5 flex justify-between bg-slate-900/30">
                                    <span class="text-slate-400 font-medium">Salário na Teoria:</span>
                                    <span class="font-semibold text-emerald-400">R$ {{ number_format($finance->salario_teorico, 2, ',', '.') }}</span>
                                </div>

                                <!-- Recebido -->
                                <div class="px-4 py-2.5 flex justify-between">
                                    <span class="text-slate-400">Recebido real:</span>
                                    <span class="font-semibold text-slate-200">R$ {{ number_format($finance->recebido, 2, ',', '.') }}</span>
                                </div>

                                <!-- Dinheiro Mãe -->
                                <div class="px-4 py-2.5 flex justify-between bg-slate-900/20">
                                    <span class="text-slate-400">Mãe:</span>
                                    <span class="font-semibold text-amber-500">R$ {{ number_format($finance->total_mae, 2, ',', '.') }}</span>
                                </div>

                                <!-- Caxinha -->
                                <div class="px-4 py-2.5 flex justify-between">
                                    <span class="text-slate-400">Caxinha:</span>
                                    <span class="font-semibold text-violet-400">R$ {{ number_format($finance->caxinha, 2, ',', '.') }}</span>
                                </div>

                                <!-- Investimento -->
                                <div class="px-4 py-2.5 flex justify-between bg-slate-900/20">
                                    <span class="text-slate-400">Investimento:</span>
                                    <span class="font-semibold text-violet-400">R$ {{ number_format($finance->investimento, 2, ',', '.') }}</span>
                                </div>

                                <!-- Fatura / Consumo -->
                                <div class="px-4 py-2.5 flex justify-between">
                                    <span class="text-slate-400">Fatura:</span>
                                    <span class="font-semibold text-rose-400">R$ {{ number_format($finance->fatura, 2, ',', '.') }}</span>
                                </div>

                                <!-- Dias Trabalhados -->
                                <div class="px-4 py-2.5 flex justify-between bg-slate-900/20">
                                    <span class="text-slate-400">Dias trabalhados:</span>
                                    <span class="font-medium text-slate-300">{{ $finance->dias_trabalhados }}</span>
                                </div>

                                <!-- Dias Condução -->
                                <div class="px-4 py-2.5 flex justify-between">
                                    <span class="text-slate-400">Dias condução:</span>
                                    <span class="font-medium text-slate-300">{{ $finance->dias_conducao }}</span>
                                </div>

                                <!-- Condução Dia (rate) -->
                                <div class="px-4 py-2.5 flex justify-between bg-slate-900/20">
                                    <span class="text-slate-400">Condução taxa:</span>
                                    <span class="font-medium text-slate-300">R$ {{ number_format($finance->conducao_dia, 2, ',', '.') }}</span>
                                </div>

                                <!-- Salário final (Sobrou) -->
                                <div class="px-4 py-3 flex justify-between bg-indigo-950/20">
                                    <span class="font-bold text-slate-300">Sobrou p/ mim:</span>
                                    <span class="font-bold text-indigo-400">R$ {{ number_format($finance->saldo_final, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modals Layer -->

    <!-- Form Modal (Create or Edit Monthly Finance) -->
    @if($showFormModal)
        <div class="fixed inset-0 z-45 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-xl overflow-hidden shadow-2xl transition-all duration-300">
                <div class="bg-slate-950 border-b border-slate-800 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-200">
                        {{ $editingId ? 'Editar Finanças Mensais' : 'Registrar Novo Mês' }}
                    </h2>
                    <button wire:click="$set('showFormModal', false)" class="text-slate-400 hover:text-slate-200 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveFinance" class="p-6 space-y-4">
                    <!-- Period Selection -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Ano de Trabalho</label>
                            <input type="number" wire:model.blur="year" min="2000" max="2100" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                            @error('year') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Mês de Trabalho</label>
                            <select wire:model.blur="month" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                                <option value="1">Janeiro</option>
                                <option value="2">Fevereiro</option>
                                <option value="3">Março</option>
                                <option value="4">Abril</option>
                                <option value="5">Maio</option>
                                <option value="6">Junho</option>
                                <option value="7">Julho</option>
                                <option value="8">Agosto</option>
                                <option value="9">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                            @error('month') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Work & Commute details -->
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Dias Trab.</label>
                            <input type="number" wire:model.live="dias_trabalhados" min="0" max="31" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                            @error('dias_trabalhados') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Dias Condução</label>
                            <input type="number" wire:model.live="dias_conducao" min="0" max="31" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                            @error('dias_conducao') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Condução Dia</label>
                            <input type="number" step="0.01" wire:model.live="conducao_dia" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                            @error('conducao_dia') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Financial Values -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Recebido real</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-2 text-slate-500 text-sm">R$</span>
                                <input type="number" step="0.01" wire:model.live="recebido" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                            </div>
                            <span class="text-[10px] text-slate-500 mt-1 block">Sugerido: R$ {{ number_format($previewSalarioTeorico, 2, ',', '.') }}</span>
                            @error('recebido') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Fatura / Consumo</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-2 text-slate-500 text-sm">R$</span>
                                <input type="number" step="0.01" wire:model.live="fatura" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                            </div>
                            @error('fatura') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Caxinha</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-2 text-slate-500 text-sm">R$</span>
                                <input type="number" step="0.01" wire:model.live="caxinha" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                            </div>
                            @error('caxinha') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Investimento</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-2 text-slate-500 text-sm">R$</span>
                                <input type="number" step="0.01" wire:model.live="investimento" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                            </div>
                            @error('investimento') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Reactive Calculation Preview Panel -->
                    <div class="bg-slate-950/70 border border-slate-800/80 rounded-xl p-4 mt-2 space-y-2.5">
                        <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Cálculo Prévio em Tempo Real</div>
                        <div class="grid grid-cols-3 gap-2 text-xs divide-x divide-slate-850">
                            <div>
                                <span class="text-slate-400 block mb-0.5">Salário Teórico:</span>
                                <span class="font-bold text-slate-200">R$ {{ number_format($previewSalarioTeorico, 2, ',', '.') }}</span>
                            </div>
                            <div class="pl-3">
                                <span class="text-slate-400 block mb-0.5">Total Mãe:</span>
                                <span class="font-bold text-slate-200">R$ {{ number_format($previewMae, 2, ',', '.') }}</span>
                            </div>
                            <div class="pl-3">
                                <span class="text-slate-400 block mb-0.5">Saldo Final:</span>
                                <span class="font-bold text-teal-400">R$ {{ number_format($previewSaldoFinal, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-850">
                        <button type="button" wire:click="$set('showFormModal', false)" class="px-5 py-2 border border-slate-800 hover:bg-slate-850 rounded-lg text-sm transition">
                            Cancelar
                        </button>
                        <button type="submit" class="px-5 py-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold rounded-lg text-sm transition shadow-lg shadow-indigo-500/10">
                            {{ $editingId ? 'Salvar Alterações' : 'Adicionar Mês' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Settings Modal (Global Constants Editor) -->
    @if($showSettingsModal)
        <div class="fixed inset-0 z-45 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl transition-all duration-300">
                <div class="bg-slate-950 border-b border-slate-800 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-200">Configurações Globais (Variáveis)</h2>
                    <button wire:click="$set('showSettingsModal', false)" class="text-slate-400 hover:text-slate-200 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveSettings" class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Bolsa-Auxílio Mensal (Base)</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2 text-slate-500 text-sm">R$</span>
                            <input type="number" step="0.01" wire:model.defer="bolsa_auxilio" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                        </div>
                        @error('bolsa_auxilio') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Auxílio Alimentação (Diário)</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2 text-slate-500 text-sm">R$</span>
                            <input type="number" step="0.01" wire:model.defer="alimentacao_dia" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                        </div>
                        @error('alimentacao_dia') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Auxílio Transporte (Diário)</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2 text-slate-500 text-sm">R$</span>
                            <input type="number" step="0.01" wire:model.defer="transporte_dia" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                        </div>
                        @error('transporte_dia') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Dinheiro Mãe (Base Fixa)</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2 text-slate-500 text-sm">R$</span>
                            <input type="number" step="0.01" wire:model.defer="dinheiro_mae" class="w-full bg-slate-950 border border-slate-800 rounded-lg pl-9 pr-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100" required>
                        </div>
                        @error('dinheiro_mae') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-850">
                        <button type="button" wire:click="$set('showSettingsModal', false)" class="px-5 py-2 border border-slate-800 hover:bg-slate-850 rounded-lg text-sm transition">
                            Cancelar
                        </button>
                        <button type="submit" class="px-5 py-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold rounded-lg text-sm transition shadow-lg shadow-indigo-500/10">
                            Salvar Configurações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- AlpineJS Toast Notification -->
    <div x-data="{ show: false, message: '' }"
         x-on:notify.window="message = $event.detail[0].message; show = true; setTimeout(() => show = false, 4000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-250"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-5 right-5 z-50 bg-slate-900 border border-slate-800 text-slate-100 px-4 py-3 rounded-lg shadow-xl flex items-center space-x-2"
         style="display: none;">
        <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span x-text="message" class="text-sm font-semibold"></span>
    </div>
    @endif
</div>
