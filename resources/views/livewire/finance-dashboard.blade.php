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
            <header class="sticky top-0 z-10 bg-slate-900/80 backdrop-blur-md border-b border-slate-800/80 px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="h-9 w-9 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight bg-gradient-to-r from-slate-100 to-slate-300 bg-clip-text text-transparent">
                            FinDesk
                        </h1>
                        <p class="text-xs text-slate-400">Gerenciador de Finanças Pessoais Desktop</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <!-- Screen Selection Tabs -->
                    <div class="flex items-center bg-slate-950/70 p-1 rounded-xl border border-slate-800/80 space-x-1">
                        <button type="button" wire:click="setScreen('dashboard')"
                            class="px-3.5 py-1.5 rounded-lg text-xs md:text-sm font-semibold transition {{ $currentScreen === 'dashboard' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200' }}">
                            Painel Geral
                        </button>
                        <button type="button" wire:click="setScreen('meses')"
                            class="px-3.5 py-1.5 rounded-lg text-xs md:text-sm font-semibold transition {{ $currentScreen === 'meses' || $currentScreen === 'detalhes' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200' }}">
                            Meus Meses
                        </button>
                        <button type="button" wire:click="setScreen('caixinhas')"
                            class="px-3.5 py-1.5 rounded-lg text-xs md:text-sm font-semibold transition {{ $currentScreen === 'caixinhas' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200' }}">
                            Caixinhas
                        </button>
                        <button type="button" wire:click="setScreen('investimentos')"
                            class="px-3.5 py-1.5 rounded-lg text-xs md:text-sm font-semibold transition {{ $currentScreen === 'investimentos' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200' }}">
                            Investimentos
                        </button>
                    </div>

                    <!-- Privacy Toggle Button -->
                    <button type="button" wire:click="togglePrivacy"
                        title="{{ $hideValues ? 'Clique para mostrar valores' : 'Clique para ocultar valores sensíveis' }}"
                        class="flex items-center space-x-2 bg-slate-900 border border-slate-800 hover:border-slate-700 active:bg-slate-950 hover:bg-slate-800 px-3 py-2 rounded-xl text-xs font-medium transition duration-200 {{ $hideValues ? 'text-amber-400 border-amber-500/30' : 'text-slate-300' }}">
                        @if($hideValues)
                            <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                            <span class="hidden sm:inline">Valores Ocultos</span>
                        @else
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span class="hidden sm:inline">Ocultar</span>
                        @endif
                    </button>

                    <!-- Global Variables Quick View Badge -->
                    <div class="hidden 2xl:flex items-center space-x-3 bg-slate-950/65 border border-slate-800/80 rounded-xl px-3.5 py-1.5 text-xs text-slate-400 select-none shadow-inner">
                        <div class="flex items-center space-x-1">
                            <span class="text-slate-500 font-medium">Bolsa:</span>
                            <span class="font-bold text-slate-200 whitespace-nowrap">
                                {{ $hideValues ? '••••' : 'R$ ' . number_format($bolsa_auxilio, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="border-l border-slate-800/80 h-3"></div>
                        <div class="flex items-center space-x-1">
                            <span class="text-slate-500 font-medium">VR/dia:</span>
                            <span class="font-bold text-slate-200 whitespace-nowrap">
                                {{ $hideValues ? '••••' : 'R$ ' . number_format($alimentacao_dia, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="border-l border-slate-800/80 h-3"></div>
                        <div class="flex items-center space-x-1">
                            <span class="text-slate-500 font-medium">Net/mês:</span>
                            <span class="font-bold text-slate-200 whitespace-nowrap">
                                {{ $hideValues ? '••••' : 'R$ ' . number_format($internet_padrao, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="border-l border-slate-800/80 h-3"></div>
                        <div class="flex items-center space-x-1">
                            <span class="text-slate-500 font-medium">Gemini/mês:</span>
                            <span class="font-bold text-slate-200 whitespace-nowrap">
                                {{ $hideValues ? '••••' : 'R$ ' . number_format($gemini_padrao, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <button type="button" wire:click="openSettingsModal"
                        class="flex items-center space-x-2 bg-slate-900 border border-slate-800 hover:border-slate-700 active:bg-slate-950 hover:bg-slate-800 px-3.5 py-2 rounded-xl text-xs font-medium transition duration-200">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Globais</span>
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
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden my-8">
                        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                            <div>
                                <h3 class="text-base font-bold text-slate-100">
                                    {{ $editingId ? 'Editar Registro Financeiro' : 'Novo Registro Mensal' }}
                                </h3>
                                <p class="text-xs text-slate-400">Preencha os dados do mês e configure despesas/repasses</p>
                            </div>
                            <button type="button" wire:click="$set('showFormModal', false)" class="text-slate-400 hover:text-slate-200">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Form Modal Tabs -->
                        <div class="px-6 pt-4 flex space-x-2 border-b border-slate-800 text-xs">
                            <button type="button" wire:click="$set('formTab', 'basico')"
                                class="pb-3 font-semibold transition border-b-2 {{ $formTab === 'basico' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
                                1. Dias & Receitas
                            </button>
                            <button type="button" wire:click="$set('formTab', 'despesas')"
                                class="pb-3 font-semibold transition border-b-2 {{ $formTab === 'despesas' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
                                2. Despesas & Fatura
                            </button>
                            <button type="button" wire:click="$set('formTab', 'extras')"
                                class="pb-3 font-semibold transition border-b-2 {{ $formTab === 'extras' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
                                3. Ignorar & Extras
                            </button>
                        </div>

                        <form wire:submit.prevent="saveFinance" class="p-6 space-y-5">
                            @if($formTab === 'basico')
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Mês</label>
                                        <select wire:model.live="month" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                            @for($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">{{ \Carbon\Carbon::create(2026, $m, 1)->locale('pt_BR')->translatedFormat('F') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Ano</label>
                                        <input type="number" wire:model.live="year" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Dias Trabalhados</label>
                                        <input type="number" wire:model.live.debounce.300ms="dias_trabalhados" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Recebido Real (R$)</label>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="recebido" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                        <span class="text-[10px] text-slate-500 mt-1 block">Sugerido p/ fórmula: R$ {{ number_format($previewSalarioTeorico, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            @elseif($formTab === 'despesas')
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Condução / Dia Mãe (R$)</label>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="conducao_dia" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Dias Condução Mãe</label>
                                        <input type="number" wire:model.live.debounce.300ms="dias_conducao" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Caixinha (R$)</label>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="caxinha" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Investimento (R$)</label>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="investimento" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Fatura Cartão (R$)</label>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="fatura" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Internet (R$)</label>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="internet" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-semibold text-slate-300 mb-1">Gemini AI (R$)</label>
                                        <input type="number" step="0.01" wire:model.live.debounce.300ms="gemini" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    </div>
                                </div>
                            @elseif($formTab === 'extras')
                                <div class="space-y-4">
                                    <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-800 space-y-3">
                                        <span class="text-xs font-bold text-slate-200 block uppercase tracking-wider">Ignorar Despesas no Cálculo</span>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_bolsa" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar Bolsa</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_alimentacao" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar VR</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_transporte" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar VT</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_dinheiro_mae" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar Mãe Fixo</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_conducao" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar Condução</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_caxinha" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar Caixinha</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_investimento" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar Investimento</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_fatura" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar Fatura</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_internet" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar Internet</span>
                                            </label>
                                            <label class="flex items-center space-x-2 text-slate-300 cursor-pointer">
                                                <input type="checkbox" wire:model.live="ignorar_gemini" class="rounded bg-slate-900 border-slate-700 text-indigo-600">
                                                <span>Ignorar Gemini</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="bg-slate-950/60 p-4 rounded-xl border border-slate-800 space-y-3">
                                        <span class="text-xs font-bold text-slate-200 block uppercase tracking-wider">Lançamento Extra (Opcional)</span>
                                        <div class="grid grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-[11px] text-slate-400 mb-1">Nome</label>
                                                <input type="text" wire:model="extra_nome" placeholder="ex: Bônus, Curso" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-1.5 text-xs text-slate-100">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] text-slate-400 mb-1">Valor (R$)</label>
                                                <input type="number" step="0.01" wire:model.live.debounce.300ms="extra_valor" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-1.5 text-xs text-slate-100">
                                            </div>
                                            <div>
                                                <label class="block text-[11px] text-slate-400 mb-1">Tipo</label>
                                                <select wire:model.live="extra_tipo" class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-1.5 text-xs text-slate-100">
                                                    <option value="saida">Saída (-)</option>
                                                    <option value="entrada">Entrada (+)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Calculation Preview Card in Modal -->
                            <div class="bg-slate-950/80 p-4 rounded-xl border border-slate-800/80 flex items-center justify-between text-xs">
                                <div>
                                    <span class="text-slate-500 block">Total Mãe Previsto:</span>
                                    <span class="font-bold text-amber-400">R$ {{ number_format($previewMae, 2, ',', '.') }}</span>
                                </div>
                                <div class="border-l border-slate-800 h-6"></div>
                                <div>
                                    <span class="text-slate-500 block">Saldo Livre Previsto:</span>
                                    <span class="font-bold {{ $previewSaldoFinal >= 0 ? 'text-teal-400' : 'text-rose-400' }}">
                                        R$ {{ number_format($previewSaldoFinal, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-end space-x-3 pt-2">
                                <button type="button" wire:click="$set('showFormModal', false)"
                                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/30 transition">
                                    Salvar Registro
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- ========================================== -->
            <!-- MODAL: CONFIGURAÇÕES GLOBAIS -->
            <!-- ========================================== -->
            @if($showSettingsModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                            <div>
                                <h3 class="text-base font-bold text-slate-100">Valores Globais Padrão</h3>
                                <p class="text-xs text-slate-400">Parâmetros utilizados ao criar novos registros</p>
                            </div>
                            <button type="button" wire:click="$set('showSettingsModal', false)" class="text-slate-400 hover:text-slate-200">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form wire:submit.prevent="saveSettings" class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Bolsa Auxílio Padrão (R$)</label>
                                <input type="number" step="0.01" wire:model="bolsa_auxilio" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Alimentação por Dia / VR (R$)</label>
                                <input type="number" step="0.01" wire:model="alimentacao_dia" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Transporte por Dia / VT (R$)</label>
                                <input type="number" step="0.01" wire:model="transporte_dia" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Dinheiro Mãe Fixo (R$)</label>
                                <input type="number" step="0.01" wire:model="dinheiro_mae" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Internet Padrão Mensal (R$)</label>
                                <input type="number" step="0.01" wire:model="internet_padrao" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Gemini AI Padrão Mensal (R$)</label>
                                <input type="number" step="0.01" wire:model="gemini_padrao" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div class="flex items-center justify-end space-x-3 pt-2">
                                <button type="button" wire:click="$set('showSettingsModal', false)"
                                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/30 transition">
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
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                            <div>
                                <h3 class="text-base font-bold text-slate-100">
                                    {{ $caixinhaId ? 'Editar Caixinha' : 'Nova Caixinha' }}
                                </h3>
                                <p class="text-xs text-slate-400">Defina o nome, objetivo e saldo da sua caixinha</p>
                            </div>
                            <button type="button" wire:click="$set('showCaixinhaModal', false)" class="text-slate-400 hover:text-slate-200">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form wire:submit.prevent="saveCaixinha" class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Nome da Caixinha</label>
                                <input type="text" wire:model="caixinhaName" placeholder="ex: Reserva de Emergência, Viagem"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none" required>
                                @error('caixinhaName') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Meta / Objetivo (R$) <span class="text-slate-500 font-normal">(opcional)</span></label>
                                <input type="number" step="0.01" wire:model="caixinhaTarget" placeholder="ex: 5000.00"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Saldo Atual (R$)</label>
                                <input type="number" step="0.01" wire:model="caixinhaBalance"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Descrição / Anotação</label>
                                <input type="text" wire:model="caixinhaDescription" placeholder="ex: Rendimento diário, para urgências"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div class="flex items-center justify-end space-x-3 pt-2">
                                <button type="button" wire:click="$set('showCaixinhaModal', false)"
                                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/30 transition">
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
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                            <div>
                                <h3 class="text-base font-bold text-slate-100">
                                    {{ $depositActionType === 'deposito' ? 'Guardar Dinheiro na Caixinha' : 'Resgatar Dinheiro da Caixinha' }}
                                </h3>
                                <p class="text-xs text-slate-400">Informe o valor da movimentação</p>
                            </div>
                            <button type="button" wire:click="$set('showDepositModal', false)" class="text-slate-400 hover:text-slate-200">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form wire:submit.prevent="processDepositAction" class="p-6 space-y-4">
                            <div class="flex p-1 bg-slate-950 rounded-xl border border-slate-800">
                                <button type="button" wire:click="$set('depositActionType', 'deposito')"
                                    class="flex-1 py-2 text-xs font-semibold rounded-lg transition {{ $depositActionType === 'deposito' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-white' }}">
                                    Guardar (+)
                                </button>
                                <button type="button" wire:click="$set('depositActionType', 'resgate')"
                                    class="flex-1 py-2 text-xs font-semibold rounded-lg transition {{ $depositActionType === 'resgate' ? 'bg-rose-600 text-white' : 'text-slate-400 hover:text-white' }}">
                                    Resgatar (-)
                                </button>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Valor (R$)</label>
                                <input type="number" step="0.01" wire:model="depositAmount" placeholder="0.00"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-lg font-bold text-slate-100 focus:border-indigo-500 focus:outline-none" required autofocus>
                                @error('depositAmount') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-4 gap-2 pt-1">
                                <button type="button" wire:click="$set('depositAmount', 20)" class="py-1.5 bg-slate-950 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300">R$ 20</button>
                                <button type="button" wire:click="$set('depositAmount', 50)" class="py-1.5 bg-slate-950 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300">R$ 50</button>
                                <button type="button" wire:click="$set('depositAmount', 100)" class="py-1.5 bg-slate-950 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300">R$ 100</button>
                                <button type="button" wire:click="$set('depositAmount', 200)" class="py-1.5 bg-slate-950 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300">R$ 200</button>
                            </div>

                            <div class="flex items-center justify-end space-x-3 pt-3">
                                <button type="button" wire:click="$set('showDepositModal', false)"
                                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 {{ $depositActionType === 'deposito' ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-rose-600 hover:bg-rose-700' }} text-white rounded-xl text-xs font-semibold shadow-lg transition">
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
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-800 flex items-center justify-between bg-slate-950/40">
                            <div>
                                <h3 class="text-base font-bold text-slate-100">
                                    {{ $investmentId ? 'Editar Investimento' : 'Novo Investimento' }}
                                </h3>
                                <p class="text-xs text-slate-400">Cadastre ou atualize a posição do seu ativo</p>
                            </div>
                            <button type="button" wire:click="$set('showInvestmentModal', false)" class="text-slate-400 hover:text-slate-200">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form wire:submit.prevent="saveInvestment" class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Nome do Ativo / Aplicação</label>
                                <input type="text" wire:model="investmentName" placeholder="ex: CDB 100% CDI, Tesouro Selic, Bitcoin"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none" required>
                                @error('investmentName') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Categoria</label>
                                <select wire:model="investmentCategory" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                                    <option value="Renda Fixa">Renda Fixa (CDB / LCI / LCA)</option>
                                    <option value="Tesouro Direto">Tesouro Direto</option>
                                    <option value="Ações">Ações</option>
                                    <option value="Fundos Imobiliários">Fundos Imobiliários (FIIs)</option>
                                    <option value="Criptomoedas">Criptomoedas</option>
                                    <option value="Fundos de Investimento">Fundos de Investimento</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Instituição / Corretora <span class="text-slate-500 font-normal">(opcional)</span></label>
                                <input type="text" wire:model="investmentInstitution" placeholder="ex: Nubank, Banco Inter, XP, Binance"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Valor Atual / Investido (R$)</label>
                                <input type="number" step="0.01" wire:model="investmentAmount"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Notas / Detalhes <span class="text-slate-500 font-normal">(opcional)</span></label>
                                <input type="text" wire:model="investmentNotes" placeholder="ex: Vencimento 2027, Liquidez diária"
                                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-indigo-500 focus:outline-none">
                            </div>
                            <div class="flex items-center justify-end space-x-3 pt-2">
                                <button type="button" wire:click="$set('showInvestmentModal', false)"
                                    class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-5 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-semibold shadow-lg shadow-violet-600/30 transition">
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