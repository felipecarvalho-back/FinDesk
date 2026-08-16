<div class="flex-1 flex flex-col h-full bg-slate-950 text-slate-100 select-none overflow-y-auto">
    @if(! $isAuthenticated)
        <!-- Tela de Login -->
        <div class="flex-1 flex flex-col justify-center items-center px-4 py-16 bg-slate-950">
            <div class="w-full max-w-sm bg-slate-900 border border-slate-800/80 p-8 rounded-2xl shadow-2xl text-center space-y-6">
                <div class="mx-auto h-12 w-12 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-slate-100">Acesso ao FinDesk</h2>
                    <p class="text-xs text-slate-400 mt-1">Por favor, insira a senha para continuar</p>
                </div>
                <form wire:submit.prevent="login" class="space-y-4">
                    <div>
                        <input type="password" wire:model="passwordInput" placeholder="Senha"
                            class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 text-slate-100 text-center tracking-widest placeholder:tracking-normal text-sm"
                            required autofocus>
                        @error('passwordInput') <span class="text-xs text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold rounded-xl text-sm transition-all duration-200 active:scale-[0.98] shadow-lg shadow-indigo-500/10">
                        Entrar
                    </button>
                </form>
            </div>
        </div>
    @else
        <div wire:key="authenticated-app-wrapper" class="flex-1 flex flex-col min-h-0 w-full relative">
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

            <!-- Main Workspace Content -->
            <div class="flex-1 p-6 space-y-6 max-w-7xl mx-auto w-full">

                <!-- ========================================== -->
                <!-- TELA 1: PAINEL GERAL (DASHBOARD) -->
                <!-- ========================================== -->
                @if($currentScreen === 'dashboard')
                    <div wire:key="screen-dashboard" class="space-y-6">
                        @if(count($finances) > 0)
                            @php
                                $totalCaxinha = collect($finances)->sum('caxinha');
                                $totalInvestidoMeses = collect($finances)->sum('investimento');
                                $totalSobrou = collect($finances)->sum('saldo_final');
                                $totalCaixinhasAtual = $this->getTotalCaixinhasBalance();
                                $totalInvestimentosAtual = $this->getTotalInvestmentsAmount();
                                $totalFaturas = collect($finances)->sum('fatura');
                                $totalInternet = collect($finances)->sum('internet');
                                $totalGemini = collect($finances)->sum('gemini');
                            @endphp

                            <!-- Top Metrics Cards (Total Recebido Geral removido) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                <!-- Card 1: Saldo Livre Acumulado -->
                                <div class="bg-slate-900/80 border border-slate-800 p-5 rounded-2xl flex items-center space-x-4 shadow-xl">
                                    <div class="h-12 w-12 rounded-xl bg-teal-500/10 flex items-center justify-center text-teal-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 font-medium block">Saldo Livre Acumulado</span>
                                        <span class="text-xl font-bold text-teal-400">
                                            {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($totalSobrou, 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card 2: Saldo em Caixinhas -->
                                <div wire:click="setScreen('caixinhas')" class="bg-slate-900/80 border border-slate-800 hover:border-indigo-500/40 p-5 rounded-2xl flex items-center space-x-4 shadow-xl cursor-pointer transition">
                                    <div class="h-12 w-12 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 font-medium block">Saldo em Caixinhas</span>
                                        <span class="text-xl font-bold text-slate-100">
                                            {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($totalCaixinhasAtual, 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card 3: Total Investido -->
                                <div wire:click="setScreen('investimentos')" class="bg-slate-900/80 border border-slate-800 hover:border-violet-500/40 p-5 rounded-2xl flex items-center space-x-4 shadow-xl cursor-pointer transition">
                                    <div class="h-12 w-12 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 font-medium block">Patrimônio Investido</span>
                                        <span class="text-xl font-bold text-slate-100">
                                            {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($totalInvestimentosAtual, 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card 4: Faturas e Despesas Fixas Mensais -->
                                <div class="bg-slate-900/80 border border-slate-800 p-5 rounded-2xl flex items-center space-x-4 shadow-xl">
                                    <div class="h-12 w-12 rounded-xl bg-rose-500/10 flex items-center justify-center text-rose-400">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs text-slate-400 font-medium block">Total Faturas & Assinaturas</span>
                                        <span class="text-xl font-bold text-rose-400">
                                            {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($totalFaturas + $totalInternet + $totalGemini, 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Graphs Grid -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Evolution Chart (Area) -->
                                <div class="lg:col-span-2 bg-slate-900/60 border border-slate-800 rounded-2xl p-6 shadow-xl" wire:ignore>
                                    <h3 class="text-sm font-bold text-slate-200 uppercase tracking-wider mb-6">
                                        Evolução Mensal (Recebido vs Sobras)
                                    </h3>
                                    <div x-data="{
                                            labels: {{ json_encode($this->getChartLabels()) }},
                                            recebido: {{ json_encode($this->getChartRecebido()) }},
                                            sobrou: {{ json_encode($this->getChartSobrou()) }},
                                            init() {
                                                let options = {
                                                    chart: {
                                                        type: 'area',
                                                        height: 320,
                                                        toolbar: { show: false },
                                                        background: 'transparent',
                                                        foreColor: '#94a3b8'
                                                    },
                                                    grid: {
                                                        borderColor: '#1e293b',
                                                        strokeDashArray: 4
                                                    },
                                                    theme: { mode: 'dark' },
                                                    colors: ['#10b981', '#6366f1'],
                                                    series: [
                                                        { name: 'Recebido Real', data: this.recebido },
                                                        { name: 'Sobrou p/ Mim', data: this.sobrou }
                                                    ],
                                                    xaxis: {
                                                        categories: this.labels,
                                                        axisBorder: { show: false },
                                                        axisTicks: { show: false }
                                                    },
                                                    yaxis: {
                                                        labels: {
                                                            formatter: function(val) {
                                                                return 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
                                                            }
                                                        }
                                                    },
                                                    tooltip: {
                                                        theme: 'dark',
                                                        y: {
                                                            formatter: function(val) {
                                                                return 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                                            }
                                                        }
                                                    },
                                                    stroke: { curve: 'smooth', width: 3 },
                                                    fill: {
                                                        type: 'gradient',
                                                        gradient: { opacityFrom: 0.35, opacityTo: 0.02 }
                                                    },
                                                    dataLabels: { enabled: false }
                                                };
                                                let chart = new ApexCharts(this.$refs.areaChart, options);
                                                chart.render();
                                            }
                                        }">
                                        <div x-ref="areaChart"></div>
                                    </div>
                                </div>

                                <!-- Donut Allocation Chart -->
                                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6 shadow-xl" wire:ignore>
                                    <h3 class="text-sm font-bold text-slate-200 uppercase tracking-wider mb-6">
                                        Distribuição de Despesas & Reservas
                                    </h3>
                                    <div x-data="{
                                            caxinha: {{ $this->getChartTotalCaxinha() }},
                                            investimento: {{ $this->getChartTotalInvestimento() }},
                                            fatura: {{ $this->getChartTotalFatura() }},
                                            mae: {{ $this->getChartTotalMae() }},
                                            internet: {{ $this->getChartTotalInternet() }},
                                            gemini: {{ $this->getChartTotalGemini() }},
                                            init() {
                                                let options = {
                                                    chart: {
                                                        type: 'donut',
                                                        height: 320,
                                                        foreColor: '#94a3b8',
                                                        background: 'transparent'
                                                    },
                                                    theme: { mode: 'dark' },
                                                    colors: ['#a855f7', '#6366f1', '#f43f5e', '#f59e0b', '#06b6d4', '#ec4899'],
                                                    series: [this.caxinha, this.investimento, this.fatura, this.mae, this.internet, this.gemini],
                                                    labels: ['Caixinha', 'Investimento', 'Fatura', 'Total Mãe', 'Internet', 'Gemini'],
                                                    legend: {
                                                        position: 'bottom',
                                                        fontSize: '11px',
                                                        markers: { radius: 12 }
                                                    },
                                                    stroke: { show: false },
                                                    dataLabels: { enabled: true },
                                                    tooltip: {
                                                        y: {
                                                            formatter: function(val) {
                                                                return 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                                            }
                                                        }
                                                    }
                                                };
                                                let chart = new ApexCharts(this.$refs.donutChart, options);
                                                chart.render();
                                            }
                                        }">
                                        <div x-ref="donutChart" class="flex justify-center"></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center text-center p-12 bg-slate-900/30 border border-slate-850 rounded-2xl min-h-[350px] space-y-4">
                                <div class="h-16 w-16 bg-slate-900 border border-slate-800 rounded-full flex items-center justify-center text-slate-500 shadow-inner">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-300">Nenhum mês cadastrado ainda</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mt-1">Cadastre o seu primeiro mês para começar a visualizar o histórico e gráficos estatísticos.</p>
                                </div>
                                <button type="button" wire:click="openCreateModal"
                                    class="mt-2 inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 px-4 py-2 rounded-xl text-xs font-semibold text-white shadow-lg shadow-indigo-600/30 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Cadastrar Mês</span>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- ========================================== -->
                <!-- TELA 2: MEUS MESES -->
                <!-- ========================================== -->
                @if($currentScreen === 'meses')
                    <div wire:key="screen-meses" class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-bold text-slate-100">Histórico de Meses</h2>
                                <p class="text-xs text-slate-400">Gerencie todos os lançamentos financeiros mensais</p>
                            </div>
                            <button type="button" wire:click="openCreateModal"
                                class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 px-4 py-2.5 rounded-xl text-xs font-semibold text-white shadow-lg shadow-indigo-600/30 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Adicionar Novo Mês</span>
                            </button>
                        </div>

                        @if(count($finances) > 0)
                            <div class="bg-slate-900/60 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-xs text-slate-300">
                                        <thead class="bg-slate-950/80 text-slate-400 uppercase font-semibold border-b border-slate-800 tracking-wider">
                                            <tr>
                                                <th class="px-5 py-3.5">Mês de Referência</th>
                                                <th class="px-4 py-3.5">Recebido</th>
                                                <th class="px-4 py-3.5">Total Mãe</th>
                                                <th class="px-4 py-3.5">Caixinha</th>
                                                <th class="px-4 py-3.5">Investimento</th>
                                                <th class="px-4 py-3.5">Fatura</th>
                                                <th class="px-4 py-3.5">Internet</th>
                                                <th class="px-4 py-3.5">Gemini</th>
                                                <th class="px-4 py-3.5">Sobrou (Saldo Livre)</th>
                                                <th class="px-5 py-3.5 text-right">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-800/60">
                                            @foreach($finances as $f)
                                                <tr class="hover:bg-slate-800/30 transition">
                                                    <td class="px-5 py-4 font-semibold text-slate-100 flex items-center space-x-2">
                                                        <span>{{ $f->month_name }} / {{ $f->year }}</span>
                                                        <span class="text-[10px] text-slate-500 font-normal block">(Recebe em {{ $f->receiving_month_name }})</span>
                                                    </td>
                                                    <td class="px-4 py-4 text-emerald-400 font-medium">
                                                        {{ $hideValues ? '••••' : 'R$ ' . number_format($f->recebido, 2, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-4 text-amber-400">
                                                        {{ $hideValues ? '••••' : 'R$ ' . number_format($f->total_mae, 2, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-4 text-indigo-400">
                                                        {{ $hideValues ? '••••' : 'R$ ' . number_format($f->caxinha, 2, ',', '.') }}
                                                        @if($f->ignorar_caxinha) <span class="text-[9px] text-slate-500 block">(ignorado)</span> @endif
                                                    </td>
                                                    <td class="px-4 py-4 text-violet-400">
                                                        {{ $hideValues ? '••••' : 'R$ ' . number_format($f->investimento, 2, ',', '.') }}
                                                        @if($f->ignorar_investimento) <span class="text-[9px] text-slate-500 block">(ignorado)</span> @endif
                                                    </td>
                                                    <td class="px-4 py-4 text-rose-400">
                                                        {{ $hideValues ? '••••' : 'R$ ' . number_format($f->fatura, 2, ',', '.') }}
                                                        @if($f->ignorar_fatura) <span class="text-[9px] text-slate-500 block">(ignorado)</span> @endif
                                                    </td>
                                                    <td class="px-4 py-4 text-cyan-400">
                                                        {{ $hideValues ? '••••' : 'R$ ' . number_format($f->internet, 2, ',', '.') }}
                                                        @if($f->ignorar_internet) <span class="text-[9px] text-slate-500 block">(ignorado)</span> @endif
                                                    </td>
                                                    <td class="px-4 py-4 text-pink-400">
                                                        {{ $hideValues ? '••••' : 'R$ ' . number_format($f->gemini, 2, ',', '.') }}
                                                        @if($f->ignorar_gemini) <span class="text-[9px] text-slate-500 block">(ignorado)</span> @endif
                                                    </td>
                                                    <td class="px-4 py-4 font-bold {{ $f->saldo_final >= 0 ? 'text-teal-400' : 'text-rose-400' }}">
                                                        {{ $hideValues ? '••••' : 'R$ ' . number_format($f->saldo_final, 2, ',', '.') }}
                                                    </td>
                                                    <td class="px-5 py-4 text-right space-x-2 whitespace-nowrap">
                                                        <button type="button" wire:click="viewMonth({{ $f->id }})"
                                                            class="text-indigo-400 hover:text-indigo-300 font-medium transition text-xs">
                                                            Detalhes
                                                        </button>
                                                        <button type="button" wire:click="openEditModal({{ $f->id }})"
                                                            class="text-slate-400 hover:text-slate-200 font-medium transition text-xs">
                                                            Editar
                                                        </button>
                                                        <button type="button" wire:click="deleteFinance({{ $f->id }})"
                                                            wire:confirm="Deseja realmente excluir este registro mensal?"
                                                            class="text-rose-400 hover:text-rose-300 font-medium transition text-xs">
                                                            Excluir
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center text-center p-12 bg-slate-900/30 border border-slate-850 rounded-2xl min-h-[300px] space-y-4">
                                <div class="h-14 w-14 bg-slate-900 border border-slate-800 rounded-full flex items-center justify-center text-slate-500 shadow-inner">
                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-300">Nenhum mês cadastrado</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mt-1">Comece adicionando seu primeiro mês de controle financeiro.</p>
                                </div>
                                <button type="button" wire:click="openCreateModal"
                                    class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl text-xs font-semibold text-white shadow-lg transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Adicionar Mês</span>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- ========================================== -->
                <!-- TELA 3: DETALHES DO MÊS -->
                <!-- ========================================== -->
                @if($currentScreen === 'detalhes' && $editingId)
                    @php
                        $selectedFinance = \App\Models\MonthlyFinance::find($editingId);
                    @endphp
                    @if($selectedFinance)
                        <div wire:key="screen-detalhes-{{ $editingId }}" class="space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <button type="button" wire:click="setScreen('meses')"
                                        class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:bg-slate-800 text-slate-400 hover:text-slate-200 transition">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                    </button>
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-100">
                                            Detalhamento: {{ $selectedFinance->month_name }} / {{ $selectedFinance->year }}
                                        </h2>
                                        <p class="text-xs text-slate-400">Recebimento referente em {{ $selectedFinance->receiving_month_name }} / {{ $selectedFinance->receiving_year }}</p>
                                    </div>
                                </div>
                                <button type="button" wire:click="openEditModal({{ $selectedFinance->id }})"
                                    class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl text-xs font-semibold text-white shadow-lg transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>Editar Este Mês</span>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Coluna 1: Entradas & Salário -->
                                <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 space-y-4 shadow-xl">
                                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                        <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider flex items-center space-x-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span>Entradas & Proventos</span>
                                        </h3>
                                    </div>
                                    <div class="space-y-3 text-xs">
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Dias Trabalhados:</span>
                                            <span class="font-bold text-slate-200">{{ $selectedFinance->dias_trabalhados }} dias</span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Bolsa Auxílio:</span>
                                            <span class="font-medium text-slate-200 {{ $selectedFinance->ignorar_bolsa ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->bolsa_auxilio_snapshot, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Alimentação (VR):</span>
                                            <span class="font-medium text-slate-200 {{ $selectedFinance->ignorar_alimentacao ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->alimentacao_dia_snapshot * $selectedFinance->dias_trabalhados, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Transporte (VT):</span>
                                            <span class="font-medium text-slate-200 {{ $selectedFinance->ignorar_transporte ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->transporte_dia_snapshot * $selectedFinance->dias_trabalhados, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="pt-3 border-t border-slate-800/80 flex justify-between items-center font-bold text-sm">
                                            <span class="text-slate-300">Salário Teórico:</span>
                                            <span class="text-emerald-400">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->salario_teorico, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center font-bold text-sm bg-slate-950/50 p-2.5 rounded-xl border border-slate-800">
                                            <span class="text-emerald-400">Recebido Real:</span>
                                            <span class="text-emerald-400">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->recebido, 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Coluna 2: Despesas & Repasses -->
                                <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 space-y-4 shadow-xl">
                                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                        <h3 class="text-sm font-bold text-rose-400 uppercase tracking-wider flex items-center space-x-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                            <span>Despesas & Compromissos</span>
                                        </h3>
                                    </div>
                                    <div class="space-y-3 text-xs">
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Mãe Fixo:</span>
                                            <span class="font-medium text-slate-200 {{ $selectedFinance->ignorar_dinheiro_mae ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->dinheiro_mae_snapshot, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Condução Mãe ({{ $selectedFinance->dias_conducao }} dias):</span>
                                            <span class="font-medium text-slate-200 {{ $selectedFinance->ignorar_conducao ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->conducao_dia * $selectedFinance->dias_conducao, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400 font-semibold pt-1 border-t border-slate-800/40">
                                            <span>Total Mãe:</span>
                                            <span class="text-amber-400">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->total_mae, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Fatura Cartão:</span>
                                            <span class="font-medium text-rose-400 {{ $selectedFinance->ignorar_fatura ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->fatura, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Internet:</span>
                                            <span class="font-medium text-cyan-400 {{ $selectedFinance->ignorar_internet ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->internet, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Gemini AI:</span>
                                            <span class="font-medium text-pink-400 {{ $selectedFinance->ignorar_gemini ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->gemini, 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Coluna 3: Reservas & Saldo Final -->
                                <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 space-y-4 shadow-xl">
                                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                                        <h3 class="text-sm font-bold text-indigo-400 uppercase tracking-wider flex items-center space-x-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Reservas & Saldo Livre</span>
                                        </h3>
                                    </div>
                                    <div class="space-y-3 text-xs">
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Guardado p/ Caixinha:</span>
                                            <span class="font-medium text-indigo-400 {{ $selectedFinance->ignorar_caxinha ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->caxinha, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-slate-400">
                                            <span>Alocado em Investimento:</span>
                                            <span class="font-medium text-violet-400 {{ $selectedFinance->ignorar_investimento ? 'line-through text-slate-500' : '' }}">
                                                {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->investimento, 2, ',', '.') }}
                                            </span>
                                        </div>
                                        @if($selectedFinance->extra_valor > 0)
                                            <div class="flex justify-between items-center text-slate-400">
                                                <span>{{ $selectedFinance->extra_nome }} ({{ $selectedFinance->extra_tipo }}):</span>
                                                <span class="font-bold {{ $selectedFinance->extra_tipo === 'entrada' ? 'text-emerald-400' : 'text-rose-400' }}">
                                                    {{ $selectedFinance->extra_tipo === 'entrada' ? '+' : '-' }}
                                                    {{ $hideValues ? '••••' : 'R$ ' . number_format($selectedFinance->extra_valor, 2, ',', '.') }}
                                                </span>
                                            </div>
                                        @endif

                                        <div class="pt-4 border-t border-slate-800 flex flex-col space-y-2">
                                            <span class="text-xs text-slate-400 font-medium">Saldo Livre Final que Sobrou:</span>
                                            <div class="p-3 bg-teal-500/10 border border-teal-500/20 rounded-xl text-center">
                                                <span class="text-2xl font-black text-teal-400 block">
                                                    {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($selectedFinance->saldo_final, 2, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- ========================================== -->
                <!-- TELA 4: CAIXINHAS -->
                <!-- ========================================== -->
                @if($currentScreen === 'caixinhas')
                    <div wire:key="screen-caixinhas" class="space-y-6">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-slate-100">Minhas Caixinhas</h2>
                                <p class="text-xs text-slate-400">Crie metas de poupança, guarde dinheiro e acompanhe seu progresso</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="bg-slate-900 border border-slate-800 rounded-xl px-4 py-2 text-xs">
                                    <span class="text-slate-400">Total Guardado:</span>
                                    <span class="font-bold text-indigo-400 ml-1">
                                        {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($this->getTotalCaixinhasBalance(), 2, ',', '.') }}
                                    </span>
                                </div>
                                <button type="button" wire:click="openCreateCaixinhaModal"
                                    class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 px-4 py-2.5 rounded-xl text-xs font-semibold text-white shadow-lg shadow-indigo-600/30 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Criar Caixinha</span>
                                </button>
                            </div>
                        </div>

                        @if(count($caixinhas) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                @foreach($caixinhas as $caixinha)
                                    @php
                                        $hasTarget = $caixinha->target_amount && $caixinha->target_amount > 0;
                                        $percent = $caixinha->progress_percentage;
                                    @endphp
                                    <div class="bg-slate-900/80 border border-slate-800 hover:border-slate-700/80 rounded-2xl p-5 shadow-xl flex flex-col justify-between space-y-4 transition group relative overflow-hidden">
                                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                                        
                                        <div class="space-y-3">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="h-10 w-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-slate-100 text-sm group-hover:text-indigo-300 transition">{{ $caixinha->name }}</h3>
                                                        @if($caixinha->description)
                                                            <p class="text-[11px] text-slate-400 line-clamp-1">{{ $caixinha->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <button type="button" wire:click="openEditCaixinhaModal({{ $caixinha->id }})"
                                                        class="p-1 text-slate-500 hover:text-slate-300 rounded transition" title="Editar">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" wire:click="deleteCaixinha({{ $caixinha->id }})"
                                                        wire:confirm="Deseja realmente excluir esta caixinha?"
                                                        class="p-1 text-slate-500 hover:text-rose-400 rounded transition" title="Excluir">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="space-y-1">
                                                <span class="text-[11px] text-slate-400 font-medium">Saldo Atual</span>
                                                <div class="text-2xl font-black text-slate-100">
                                                    {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($caixinha->balance, 2, ',', '.') }}
                                                </div>
                                            </div>

                                            @if($hasTarget)
                                                <div class="space-y-1.5 pt-1">
                                                    <div class="flex justify-between text-[11px] text-slate-400">
                                                        <span>Meta: {{ $hideValues ? '••••' : 'R$ ' . number_format($caixinha->target_amount, 2, ',', '.') }}</span>
                                                        <span class="font-bold text-indigo-400">{{ $percent }}%</span>
                                                    </div>
                                                    <div class="w-full bg-slate-950 rounded-full h-2 overflow-hidden border border-slate-800">
                                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Quick Action Buttons -->
                                        <div class="pt-3 border-t border-slate-800/80 space-y-2">
                                            <div class="grid grid-cols-2 gap-2">
                                                <button type="button" wire:click="quickDeposit({{ $caixinha->id }}, 50)"
                                                    class="py-1.5 px-2 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-emerald-400 hover:text-emerald-300 transition text-center">
                                                    + R$ 50
                                                </button>
                                                <button type="button" wire:click="quickDeposit({{ $caixinha->id }}, 100)"
                                                    class="py-1.5 px-2 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-emerald-400 hover:text-emerald-300 transition text-center">
                                                    + R$ 100
                                                </button>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <button type="button" wire:click="openDepositModal({{ $caixinha->id }}, 'deposito')"
                                                    class="py-2 px-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center space-x-1 shadow-md shadow-indigo-600/20">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    <span>Guardar</span>
                                                </button>
                                                <button type="button" wire:click="openDepositModal({{ $caixinha->id }}, 'resgate')"
                                                    class="py-2 px-3 bg-slate-950 hover:bg-slate-800 border border-slate-800 text-slate-300 hover:text-white rounded-xl text-xs font-semibold transition flex items-center justify-center space-x-1">
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                    </svg>
                                                    <span>Resgatar</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center text-center p-12 bg-slate-900/30 border border-slate-850 rounded-2xl min-h-[350px] space-y-4">
                                <div class="h-16 w-16 bg-slate-900 border border-slate-800 rounded-full flex items-center justify-center text-indigo-400 shadow-inner">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-300">Nenhuma caixinha criada</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mt-1">Crie caixinhas para organizar sua reserva de emergência, viagens, compras ou objetivos futuros.</p>
                                </div>
                                <button type="button" wire:click="openCreateCaixinhaModal"
                                    class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl text-xs font-semibold text-white shadow-lg shadow-indigo-600/30 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Criar Minha Primeira Caixinha</span>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- ========================================== -->
                <!-- TELA 5: INVESTIMENTOS -->
                <!-- ========================================== -->
                @if($currentScreen === 'investimentos')
                    <div wire:key="screen-investimentos" class="space-y-6">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-bold text-slate-100">Carteira de Investimentos</h2>
                                <p class="text-xs text-slate-400">Cadastre seus ativos, categorias e acompanhe o valor investido</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="bg-slate-900 border border-slate-800 rounded-xl px-4 py-2 text-xs">
                                    <span class="text-slate-400">Patrimônio Total:</span>
                                    <span class="font-bold text-violet-400 ml-1">
                                        {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($this->getTotalInvestmentsAmount(), 2, ',', '.') }}
                                    </span>
                                </div>
                                <button type="button" wire:click="openCreateInvestmentModal"
                                    class="inline-flex items-center space-x-2 bg-violet-600 hover:bg-violet-700 active:bg-violet-800 px-4 py-2.5 rounded-xl text-xs font-semibold text-white shadow-lg shadow-violet-600/30 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Novo Investimento</span>
                                </button>
                            </div>
                        </div>

                        @if(count($investments) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                @foreach($investments as $inv)
                                    <div class="bg-slate-900/80 border border-slate-800 hover:border-slate-700 rounded-2xl p-5 shadow-xl flex flex-col justify-between space-y-4 transition group">
                                        <div class="space-y-3">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-violet-500/10 text-violet-400 border border-violet-500/20 mb-1.5">
                                                        {{ $inv->category }}
                                                    </span>
                                                    <h3 class="font-bold text-slate-100 text-sm group-hover:text-violet-300 transition">{{ $inv->name }}</h3>
                                                    @if($inv->institution)
                                                        <p class="text-[11px] text-slate-400">{{ $inv->institution }}</p>
                                                    @endif
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <button type="button" wire:click="openEditInvestmentModal({{ $inv->id }})"
                                                        class="p-1 text-slate-500 hover:text-slate-300 rounded transition" title="Editar">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" wire:click="deleteInvestment({{ $inv->id }})"
                                                        wire:confirm="Deseja realmente excluir este investimento?"
                                                        class="p-1 text-slate-500 hover:text-rose-400 rounded transition" title="Excluir">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="space-y-1">
                                                <span class="text-[11px] text-slate-400 font-medium">Valor Aplicado / Saldo</span>
                                                <div class="text-2xl font-black text-slate-100">
                                                    {{ $hideValues ? 'R$ ••••••' : 'R$ ' . number_format($inv->amount, 2, ',', '.') }}
                                                </div>
                                            </div>

                                            @if($inv->notes)
                                                <p class="text-xs text-slate-400 bg-slate-950/60 p-2.5 rounded-xl border border-slate-800/80">
                                                    {{ $inv->notes }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="pt-3 border-t border-slate-800/80 flex justify-end">
                                            <button type="button" wire:click="openEditInvestmentModal({{ $inv->id }})"
                                                class="w-full py-2 px-3 bg-slate-950 hover:bg-slate-800 border border-slate-800 text-slate-300 hover:text-white rounded-xl text-xs font-semibold transition text-center">
                                                Atualizar Valor / Dados
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center text-center p-12 bg-slate-900/30 border border-slate-850 rounded-2xl min-h-[350px] space-y-4">
                                <div class="h-16 w-16 bg-slate-900 border border-slate-800 rounded-full flex items-center justify-center text-violet-400 shadow-inner">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-300">Nenhum investimento cadastrado</h4>
                                    <p class="text-xs text-slate-500 max-w-sm mt-1">Indique quais ativos você possui (CDB, Ações, Tesouro Direto, Cripto, etc.) e acompanhe seus valores.</p>
                                </div>
                                <button type="button" wire:click="openCreateInvestmentModal"
                                    class="inline-flex items-center space-x-2 bg-violet-600 hover:bg-violet-700 px-4 py-2 rounded-xl text-xs font-semibold text-white shadow-lg shadow-violet-600/30 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Cadastrar Investimento</span>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- ========================================== -->
            <!-- MODAL: CRIAR / EDITAR MÊS -->
            <!-- ========================================== -->
            @if($showFormModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div class="bg-slate-900 border border-slate-800/90 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden my-6 animate-in fade-in zoom-in-95 duration-150">
                        {{-- Modal Header --}}
                        <div class="px-5 py-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/40">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-xl bg-indigo-500/15 border border-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-100">
                                        {{ $editingId ? 'Editar Registro Financeiro' : 'Novo Registro Mensal' }}
                                    </h3>
                                    <p class="text-xs text-slate-400">Preencha os dados do mês e configure despesas/repasses</p>
                                </div>
                            </div>
                            <button type="button" wire:click="$set('showFormModal', false)"
                                class="text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 rounded-lg p-1.5 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Form Modal Tabs (Segmented Control) --}}
                        <div class="px-5 pt-4 pb-1">
                            <div class="flex items-center bg-slate-950/90 p-1 rounded-xl border border-slate-800/80 shadow-inner gap-1">
                                <button type="button" wire:click="$set('formTab', 'basico')"
                                    class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5 {{ $formTab === 'basico' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                                    <span>1. Receitas & Dias</span>
                                    @if($errors->hasAny(['month', 'year', 'dias_trabalhados', 'recebido']))
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                    @endif
                                </button>
                                <button type="button" wire:click="$set('formTab', 'despesas')"
                                    class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5 {{ $formTab === 'despesas' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                                    <span>2. Despesas</span>
                                    @if($errors->hasAny(['conducao_dia', 'dias_conducao', 'caxinha', 'investimento', 'fatura', 'internet', 'gemini']))
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                    @endif
                                </button>
                                <button type="button" wire:click="$set('formTab', 'extras')"
                                    class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5 {{ $formTab === 'extras' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                                    <span>3. Extras & Ignorar</span>
                                    @if($errors->hasAny(['extra_valor', 'extra_nome', 'extra_tipo']))
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                    @endif
                                </button>
                            </div>
                        </div>

                        <form wire:submit.prevent="saveFinance" class="p-5 space-y-4">
                            @if($errors->any())
                                <div class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-xl text-xs text-rose-300 space-y-1">
                                    <p class="font-bold flex items-center gap-1.5 text-rose-400">
                                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span>Corrija os campos com erro para salvar:</span>
                                    </p>
                                    <ul class="list-disc list-inside text-[11px] text-rose-300/90 pl-1 space-y-0.5">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- TAB 1: BÁSICO (RECEITAS & DIAS) --}}
                            <div wire:key="container-tab-basico" class="{{ $formTab === 'basico' ? 'space-y-3.5' : 'hidden' }}">
                                <div class="grid grid-cols-2 gap-3.5">
                                    <div wire:key="field-wrapper-month" class="space-y-1">
                                        <label for="field_month" class="block text-xs font-semibold text-slate-300">Mês de Referência</label>
                                        <select id="field_month" name="month" wire:key="input-field-month" wire:model="month"
                                            class="w-full bg-slate-950/80 border {{ $errors->has('month') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                                            @for($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">{{ \Carbon\Carbon::create(2026, $m, 1)->locale('pt_BR')->translatedFormat('F') }}</option>
                                            @endfor
                                        </select>
                                        @error('month') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-year" class="space-y-1">
                                        <label for="field_year" class="block text-xs font-semibold text-slate-300">Ano</label>
                                        <input type="number" id="field_year" name="year" wire:key="input-field-year" wire:model="year"
                                            class="w-full bg-slate-950/80 border {{ $errors->has('year') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        @error('year') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-dias-trabalhados" class="space-y-1">
                                        <label for="field_dias_trabalhados" class="block text-xs font-semibold text-slate-300">Dias Trabalhados</label>
                                        <input type="number" id="field_dias_trabalhados" name="dias_trabalhados" wire:key="input-field-dias-trabalhados" wire:model="dias_trabalhados" placeholder="ex: 20"
                                            class="w-full bg-slate-950/80 border {{ $errors->has('dias_trabalhados') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        @error('dias_trabalhados') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-recebido" class="space-y-1">
                                        <label for="field_recebido" class="block text-xs font-semibold text-slate-300">Recebido Real</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                            <input type="number" step="0.01" id="field_recebido" name="recebido" wire:key="input-field-recebido" wire:model="recebido"
                                                class="w-full bg-slate-950/80 border {{ $errors->has('recebido') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-bold text-emerald-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                        <span class="text-[10px] text-slate-500 block mt-0.5">Sugerido: R$ {{ number_format($previewSalarioTeorico, 2, ',', '.') }}</span>
                                        @error('recebido') <span class="text-rose-400 text-[10px] block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 2: DESPESAS --}}
                            <div wire:key="container-tab-despesas" class="{{ $formTab === 'despesas' ? 'space-y-3.5' : 'hidden' }}">
                                <div class="grid grid-cols-2 gap-3.5">
                                    <div wire:key="field-wrapper-conducao-dia" class="space-y-1">
                                        <label for="field_conducao_dia" class="block text-xs font-semibold text-slate-300">Condução / Dia Mãe</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                            <input type="number" step="0.01" id="field_conducao_dia" name="conducao_dia" wire:key="input-field-conducao-dia" wire:model="conducao_dia"
                                                class="w-full bg-slate-950/80 border {{ $errors->has('conducao_dia') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                        @error('conducao_dia') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-dias-conducao" class="space-y-1">
                                        <label for="field_dias_conducao" class="block text-xs font-semibold text-slate-300">Dias Condução Mãe</label>
                                        <input type="number" id="field_dias_conducao" name="dias_conducao" wire:key="input-field-dias-conducao" wire:model="dias_conducao" placeholder="ex: 20"
                                            class="w-full bg-slate-950/80 border {{ $errors->has('dias_conducao') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        @error('dias_conducao') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-caxinha" class="space-y-1">
                                        <label for="field_caxinha" class="block text-xs font-semibold text-slate-300">Caixinha</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                            <input type="number" step="0.01" id="field_caxinha" name="caxinha" wire:key="input-field-caxinha" wire:model="caxinha"
                                                class="w-full bg-slate-950/80 border {{ $errors->has('caxinha') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                        @error('caxinha') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-investimento" class="space-y-1">
                                        <label for="field_investimento" class="block text-xs font-semibold text-slate-300">Investimento</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                            <input type="number" step="0.01" id="field_investimento" name="investimento" wire:key="input-field-investimento" wire:model="investimento"
                                                class="w-full bg-slate-950/80 border {{ $errors->has('investimento') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                        @error('investimento') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-fatura" class="space-y-1">
                                        <label for="field_fatura" class="block text-xs font-semibold text-slate-300">Fatura Cartão</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                            <input type="number" step="0.01" id="field_fatura" name="fatura" wire:key="input-field-fatura" wire:model="fatura"
                                                class="w-full bg-slate-950/80 border {{ $errors->has('fatura') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-rose-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                        @error('fatura') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-internet" class="space-y-1">
                                        <label for="field_internet" class="block text-xs font-semibold text-slate-300">Internet</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                            <input type="number" step="0.01" id="field_internet" name="internet" wire:key="input-field-internet" wire:model="internet"
                                                class="w-full bg-slate-950/80 border {{ $errors->has('internet') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                        @error('internet') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:key="field-wrapper-gemini" class="col-span-2 space-y-1">
                                        <label for="field_gemini" class="block text-xs font-semibold text-slate-300">Gemini AI</label>
                                        <div class="relative rounded-xl shadow-sm">
                                            <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                            <input type="number" step="0.01" id="field_gemini" name="gemini" wire:key="input-field-gemini" wire:model="gemini"
                                                class="w-full bg-slate-950/80 border {{ $errors->has('gemini') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                        @error('gemini') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 3: EXTRAS & IGNORAR --}}
                            <div wire:key="container-tab-extras" class="{{ $formTab === 'extras' ? 'space-y-3.5' : 'hidden' }}">
                                <div class="space-y-3.5">
                                    <div class="bg-slate-950/70 p-3.5 rounded-xl border border-slate-800/80 space-y-2.5">
                                        <span class="text-[11px] font-bold text-slate-400 block uppercase tracking-wider">Ignorar Despesas no Cálculo</span>
                                        <div class="grid grid-cols-2 gap-2 text-xs">
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_bolsa" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar Bolsa</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_alimentacao" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar VR</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_transporte" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar VT</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_dinheiro_mae" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar Mãe Fixo</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_conducao" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar Condução</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_caxinha" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar Caixinha</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_investimento" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar Investimento</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_fatura" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar Fatura</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_internet" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar Internet</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                                <input type="checkbox" wire:model.live="ignorar_gemini" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                                <span>Ignorar Gemini</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="bg-slate-950/70 p-3.5 rounded-xl border border-slate-800/80 space-y-2.5">
                                        <span class="text-[11px] font-bold text-slate-400 block uppercase tracking-wider">Lançamento Extra (Opcional)</span>
                                        <div class="grid grid-cols-3 gap-2.5">
                                            <div wire:key="field-wrapper-extra-nome" class="space-y-1">
                                                <label for="field_extra_nome" class="block text-[10px] font-semibold text-slate-400">Nome</label>
                                                <input type="text" id="field_extra_nome" name="extra_nome" wire:key="input-field-extra-nome" wire:model="extra_nome" placeholder="ex: Bônus"
                                                    class="w-full bg-slate-900/80 border border-slate-800 rounded-lg px-2.5 py-1.5 text-xs text-slate-100 focus:border-indigo-500 focus:outline-none">
                                            </div>
                                            <div wire:key="field-wrapper-extra-valor" class="space-y-1">
                                                <label for="field_extra_valor" class="block text-[10px] font-semibold text-slate-400">Valor (R$)</label>
                                                <input type="number" step="0.01" id="field_extra_valor" name="extra_valor" wire:key="input-field-extra-valor" wire:model="extra_valor" placeholder="0.00"
                                                    class="w-full bg-slate-900/80 border border-slate-800 rounded-lg px-2.5 py-1.5 text-xs text-slate-100 focus:border-indigo-500 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                            </div>
                                            <div wire:key="field-wrapper-extra-tipo" class="space-y-1">
                                                <label for="field_extra_tipo" class="block text-[10px] font-semibold text-slate-400">Tipo</label>
                                                <select id="field_extra_tipo" name="extra_tipo" wire:key="input-field-extra-tipo" wire:model="extra_tipo"
                                                    class="w-full bg-slate-900/80 border border-slate-800 rounded-lg px-2 py-1.5 text-xs text-slate-100 focus:border-indigo-500 focus:outline-none">
                                                    <option value="saida">Saída (-)</option>
                                                    <option value="entrada">Entrada (+)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Calculation Preview Card in Modal --}}
                            <div class="bg-slate-950/90 p-3.5 rounded-xl border border-slate-800/80 flex items-center justify-between text-xs shadow-inner">
                                <div>
                                    <span class="text-[11px] text-slate-400 block font-medium">Total Mãe Previsto</span>
                                    <span class="font-bold text-amber-400 text-sm">R$ {{ number_format($previewMae, 2, ',', '.') }}</span>
                                </div>
                                <div class="border-l border-slate-800 h-7"></div>
                                <div class="text-right">
                                    <span class="text-[11px] text-slate-400 block font-medium">Saldo Livre Previsto</span>
                                    <span class="font-bold text-sm {{ $previewSaldoFinal >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                        R$ {{ number_format($previewSaldoFinal, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Footer Actions --}}
                            <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-800/60">
                                <button type="button" wire:click="$set('showFormModal', false)"
                                    class="px-4 py-2 bg-slate-800/80 hover:bg-slate-700 active:scale-95 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/25 transition">
                                    Salvar Registro
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- MODAL: CONFIGURAÇÕES GLOBAIS (FALLBACK WEB) -->
            <!-- ========================================== -->
            @if($showSettingsModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div class="bg-[#0f1117] border border-white/[0.08] rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                        {{-- Modal Header --}}
                        <div class="px-5 py-4 border-b border-white/[0.07] flex items-center justify-between bg-[#0c0e15]">
                            <div class="flex items-center gap-2.5">
                                <div class="h-8 w-8 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-100">Valores Globais Padrão</h3>
                                    <p class="text-[11px] text-slate-500">Parâmetros base para novos meses</p>
                                </div>
                            </div>
                        </div>

                        <form wire:submit.prevent="saveSettings" class="p-4 space-y-3.5">
                            {{-- Renda Base --}}
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Renda</p>
                                <div class="rounded-xl border border-white/[0.07] overflow-hidden">
                                    <div class="flex items-center bg-slate-900/40 px-3.5 py-2.5 gap-3">
                                        <div class="flex-1 min-w-0">
                                            <label for="global_bolsa_auxilio" class="text-xs font-semibold text-slate-200 block cursor-pointer">Bolsa Auxílio</label>
                                            <p class="text-[10px] text-slate-500">Valor base mensal</p>
                                        </div>
                                        <div class="flex items-center shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 transition">
                                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none">R$</span>
                                            <input type="number" step="0.01" id="global_bolsa_auxilio" name="bolsa_auxilio" wire:key="global-input-bolsa-auxilio" wire:model="bolsa_auxilio"
                                                class="flex-1 min-w-0 bg-transparent py-1 pr-2.5 text-xs font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                    </div>
                                </div>
                                @error('bolsa_auxilio') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                            </div>

                            {{-- Despesas Fixas --}}
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Despesas Fixas</p>
                                <div class="rounded-xl border border-white/[0.07] overflow-hidden divide-y divide-white/[0.07]">
                                    <div class="flex items-center bg-slate-900/40 px-3.5 py-2.5 gap-3">
                                        <div class="flex-1 min-w-0">
                                            <label for="global_dinheiro_mae" class="text-xs font-semibold text-slate-200 block cursor-pointer">Dinheiro Mãe</label>
                                            <p class="text-[10px] text-slate-500">Repasse mensal fixo</p>
                                        </div>
                                        <div class="flex items-center shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 transition">
                                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none">R$</span>
                                            <input type="number" step="0.01" id="global_dinheiro_mae" name="dinheiro_mae" wire:key="global-input-dinheiro-mae" wire:model="dinheiro_mae"
                                                class="flex-1 min-w-0 bg-transparent py-1 pr-2.5 text-xs font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-slate-900/40 px-3.5 py-2.5 gap-3">
                                        <div class="flex-1 min-w-0">
                                            <label for="global_internet_padrao" class="text-xs font-semibold text-slate-200 block cursor-pointer">Internet</label>
                                            <p class="text-[10px] text-slate-500">Plano mensal</p>
                                        </div>
                                        <div class="flex items-center shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 transition">
                                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none">R$</span>
                                            <input type="number" step="0.01" id="global_internet_padrao" name="internet_padrao" wire:key="global-input-internet-padrao" wire:model="internet_padrao"
                                                class="flex-1 min-w-0 bg-transparent py-1 pr-2.5 text-xs font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-slate-900/40 px-3.5 py-2.5 gap-3">
                                        <div class="flex-1 min-w-0">
                                            <label for="global_gemini_padrao" class="text-xs font-semibold text-slate-200 block cursor-pointer">Gemini AI</label>
                                            <p class="text-[10px] text-slate-500">Assinatura mensal</p>
                                        </div>
                                        <div class="flex items-center shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 transition">
                                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none">R$</span>
                                            <input type="number" step="0.01" id="global_gemini_padrao" name="gemini_padrao" wire:key="global-input-gemini-padrao" wire:model="gemini_padrao"
                                                class="flex-1 min-w-0 bg-transparent py-1 pr-2.5 text-xs font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                    </div>
                                </div>
                                @error('dinheiro_mae') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                @error('internet_padrao') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                @error('gemini_padrao') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                            </div>

                            {{-- Custos Diários --}}
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Custos Diários</p>
                                <div class="rounded-xl border border-white/[0.07] overflow-hidden divide-y divide-white/[0.07]">
                                    <div class="flex items-center bg-slate-900/40 px-3.5 py-2.5 gap-3">
                                        <div class="flex-1 min-w-0">
                                            <label for="global_alimentacao_dia" class="text-xs font-semibold text-slate-200 block cursor-pointer">Alimentação / VR</label>
                                            <p class="text-[10px] text-slate-500">Refeição por dia útil</p>
                                        </div>
                                        <div class="flex items-center shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 transition">
                                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none">R$</span>
                                            <input type="number" step="0.01" id="global_alimentacao_dia" name="alimentacao_dia" wire:key="global-input-alimentacao-dia" wire:model="alimentacao_dia"
                                                class="flex-1 min-w-0 bg-transparent py-1 pr-2.5 text-xs font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-slate-900/40 px-3.5 py-2.5 gap-3">
                                        <div class="flex-1 min-w-0">
                                            <label for="global_transporte_dia" class="text-xs font-semibold text-slate-200 block cursor-pointer">Transporte / VT</label>
                                            <p class="text-[10px] text-slate-500">Passagem por dia útil</p>
                                        </div>
                                        <div class="flex items-center shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 transition">
                                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none">R$</span>
                                            <input type="number" step="0.01" id="global_transporte_dia" name="transporte_dia" wire:key="global-input-transporte-dia" wire:model="transporte_dia"
                                                class="flex-1 min-w-0 bg-transparent py-1 pr-2.5 text-xs font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        </div>
                                    </div>
                                </div>
                                @error('alimentacao_dia') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                                @error('transporte_dia') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-white/[0.07]">
                                <button type="button" wire:click="$set('showSettingsModal', false)"
                                    class="px-4 py-2 bg-white/[0.06] hover:bg-white/[0.10] active:scale-95 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/25 transition">
                                    Salvar Globais
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- MODAL: CRIAR / EDITAR CAIXINHA -->
            <!-- ========================================== -->
            @if($showCaixinhaModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div class="bg-slate-900 border border-slate-800/90 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                        {{-- Modal Header --}}
                        <div class="px-5 py-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/40">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-xl bg-indigo-500/15 border border-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-100">
                                        {{ $caixinhaId ? 'Editar Caixinha' : 'Nova Caixinha' }}
                                    </h3>
                                    <p class="text-xs text-slate-400">Defina o nome, objetivo e saldo da caixinha</p>
                                </div>
                            </div>
                            <button type="button" wire:click="$set('showCaixinhaModal', false)"
                                class="text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 rounded-lg p-1.5 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form wire:submit.prevent="saveCaixinha" class="p-5 space-y-3.5">
                            <div wire:key="caixinha-field-name" class="space-y-1">
                                <label for="caixinha_name" class="block text-xs font-semibold text-slate-300">Nome da Caixinha</label>
                                <input type="text" id="caixinha_name" name="caixinhaName" wire:key="input-caixinha-name" wire:model="caixinhaName" placeholder="ex: Reserva de Emergência, Viagem"
                                    class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3.5 py-2 text-sm text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition" required>
                                @error('caixinhaName') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div wire:key="caixinha-field-target" class="space-y-1">
                                    <label for="caixinha_target" class="block text-xs font-semibold text-slate-300">Meta <span class="text-slate-500 font-normal">(opcional)</span></label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                        <input type="number" step="0.01" id="caixinha_target" name="caixinhaTarget" wire:key="input-caixinha-target" wire:model="caixinhaTarget" placeholder="5000.00"
                                            class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                    </div>
                                </div>
                                <div wire:key="caixinha-field-balance" class="space-y-1">
                                    <label for="caixinha_balance" class="block text-xs font-semibold text-slate-300">Saldo Atual</label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                        <input type="number" step="0.01" id="caixinha_balance" name="caixinhaBalance" wire:key="input-caixinha-balance" wire:model="caixinhaBalance" placeholder="0.00"
                                            class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-8 pr-3 py-2 text-sm font-bold text-indigo-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" required>
                                    </div>
                                </div>
                            </div>
                            <div wire:key="caixinha-field-desc" class="space-y-1">
                                <label for="caixinha_description" class="block text-xs font-semibold text-slate-300">Descrição / Anotação <span class="text-slate-500 font-normal">(opcional)</span></label>
                                <input type="text" id="caixinha_description" name="caixinhaDescription" wire:key="input-caixinha-desc" wire:model="caixinhaDescription" placeholder="ex: Rendimento diário, meta até final do ano"
                                    class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3.5 py-2 text-sm text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                            </div>
                            <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-800/60">
                                <button type="button" wire:click="$set('showCaixinhaModal', false)"
                                    class="px-4 py-2 bg-slate-800/80 hover:bg-slate-700 active:scale-95 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/25 transition">
                                    Salvar Caixinha
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- MODAL: DEPÓSITO / RESGATE EM CAIXINHA -->
            <!-- ========================================== -->
            @if($showDepositModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div class="bg-slate-900 border border-slate-800/90 rounded-2xl w-full max-w-sm shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                        {{-- Modal Header --}}
                        <div class="px-5 py-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/40">
                            <div>
                                <h3 class="text-sm font-bold text-slate-100">
                                    {{ $depositActionType === 'deposito' ? 'Guardar Dinheiro' : 'Resgatar Dinheiro' }}
                                </h3>
                                <p class="text-xs text-slate-400">Informe o valor da movimentação</p>
                            </div>
                            <button type="button" wire:click="$set('showDepositModal', false)"
                                class="text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 rounded-lg p-1.5 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form wire:submit.prevent="processDepositAction" class="p-5 space-y-3.5">
                            {{-- Action Switcher --}}
                            <div class="flex p-1 bg-slate-950 rounded-xl border border-slate-800/80 gap-1">
                                <button type="button" wire:click="$set('depositActionType', 'deposito')"
                                    class="flex-1 py-1.5 text-xs font-semibold rounded-lg transition {{ $depositActionType === 'deposito' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200' }}">
                                    + Guardar
                                </button>
                                <button type="button" wire:click="$set('depositActionType', 'resgate')"
                                    class="flex-1 py-1.5 text-xs font-semibold rounded-lg transition {{ $depositActionType === 'resgate' ? 'bg-rose-600 text-white shadow-sm shadow-rose-600/30' : 'text-slate-400 hover:text-slate-200' }}">
                                    - Resgatar
                                </button>
                            </div>

                            <div wire:key="deposit-field-amount" class="space-y-1">
                                <label for="deposit_amount" class="block text-xs font-semibold text-slate-300">Valor da Operação</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <span class="absolute left-3.5 top-2.5 text-sm font-semibold text-slate-500 pointer-events-none">R$</span>
                                    <input type="number" step="0.01" id="deposit_amount" name="depositAmount" wire:key="input-deposit-amount" wire:model="depositAmount" placeholder="0.00"
                                        class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-9 pr-3.5 py-2.5 text-base font-bold text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" required autofocus>
                                </div>
                                @error('depositAmount') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-4 gap-1.5 pt-0.5">
                                <button type="button" wire:click="$set('depositAmount', 20)" class="py-1.5 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition active:scale-95">+ R$ 20</button>
                                <button type="button" wire:click="$set('depositAmount', 50)" class="py-1.5 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition active:scale-95">+ R$ 50</button>
                                <button type="button" wire:click="$set('depositAmount', 100)" class="py-1.5 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition active:scale-95">+ R$ 100</button>
                                <button type="button" wire:click="$set('depositAmount', 200)" class="py-1.5 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition active:scale-95">+ R$ 200</button>
                            </div>

                            <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-800/60">
                                <button type="button" wire:click="$set('showDepositModal', false)"
                                    class="px-4 py-2 bg-slate-800/80 hover:bg-slate-700 active:scale-95 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 {{ $depositActionType === 'deposito' ? 'bg-indigo-600 hover:bg-indigo-500 shadow-indigo-600/25' : 'bg-rose-600 hover:bg-rose-500 shadow-rose-600/25' }} text-white rounded-xl text-xs font-semibold shadow-lg transition active:scale-95">
                                    Confirmar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- MODAL: CRIAR / EDITAR INVESTIMENTO -->
            <!-- ========================================== -->
            @if($showInvestmentModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div class="bg-slate-900 border border-slate-800/90 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                        {{-- Modal Header --}}
                        <div class="px-5 py-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/40">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-xl bg-violet-500/15 border border-violet-500/20 text-violet-400 flex items-center justify-center shrink-0">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-100">
                                        {{ $investmentId ? 'Editar Investimento' : 'Novo Investimento' }}
                                    </h3>
                                    <p class="text-xs text-slate-400">Cadastre ou atualize a posição do ativo</p>
                                </div>
                            </div>
                            <button type="button" wire:click="$set('showInvestmentModal', false)"
                                class="text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 rounded-lg p-1.5 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form wire:submit.prevent="saveInvestment" class="p-5 space-y-3.5">
                            <div wire:key="inv-field-name" class="space-y-1">
                                <label for="investment_name" class="block text-xs font-semibold text-slate-300">Nome do Ativo / Aplicação</label>
                                <input type="text" id="investment_name" name="investmentName" wire:key="input-investment-name" wire:model="investmentName" placeholder="ex: CDB 100% CDI, Tesouro Selic, Bitcoin"
                                    class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3.5 py-2 text-sm text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition" required>
                                @error('investmentName') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div wire:key="inv-field-cat" class="space-y-1">
                                    <label for="investment_cat" class="block text-xs font-semibold text-slate-300">Categoria</label>
                                    <select id="investment_cat" name="investmentCategory" wire:key="input-investment-category" wire:model="investmentCategory"
                                        class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3 py-2 text-xs font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                                        <option value="Renda Fixa">Renda Fixa (CDB/LCI)</option>
                                        <option value="Tesouro Direto">Tesouro Direto</option>
                                        <option value="Ações">Ações</option>
                                        <option value="Fundos Imobiliários">FIIs</option>
                                        <option value="Criptomoedas">Cripto</option>
                                        <option value="Fundos de Investimento">Fundos</option>
                                        <option value="Outros">Outros</option>
                                    </select>
                                </div>
                                <div wire:key="inv-field-inst" class="space-y-1">
                                    <label for="investment_inst" class="block text-xs font-semibold text-slate-300">Instituição</label>
                                    <input type="text" id="investment_inst" name="investmentInstitution" wire:key="input-investment-institution" wire:model="investmentInstitution" placeholder="ex: Nubank, XP"
                                        class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                                </div>
                            </div>
                            <div wire:key="inv-field-amount" class="space-y-1">
                                <label for="investment_amount" class="block text-xs font-semibold text-slate-300">Valor Investido</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <span class="absolute left-3.5 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                    <input type="number" step="0.01" id="investment_amount" name="investmentAmount" wire:key="input-investment-amount" wire:model="investmentAmount" placeholder="0.00"
                                        class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-9 pr-3.5 py-2 text-sm font-bold text-violet-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" required>
                                </div>
                            </div>
                            <div wire:key="inv-field-notes" class="space-y-1">
                                <label for="investment_notes" class="block text-xs font-semibold text-slate-300">Notas / Detalhes <span class="text-slate-500 font-normal">(opcional)</span></label>
                                <input type="text" id="investment_notes" name="investmentNotes" wire:key="input-investment-notes" wire:model="investmentNotes" placeholder="ex: Vencimento 2027, Liquidez diária"
                                    class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3.5 py-2 text-sm text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                            </div>
                            <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-800/60">
                                <button type="button" wire:click="$set('showInvestmentModal', false)"
                                    class="px-4 py-2 bg-slate-800/80 hover:bg-slate-700 active:scale-95 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-violet-600 hover:bg-violet-500 active:scale-95 text-white rounded-xl text-xs font-semibold shadow-lg shadow-violet-600/25 transition">
                                    Salvar Investimento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    @endif
</div>