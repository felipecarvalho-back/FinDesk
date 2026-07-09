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
        <div wire:key="authenticated-app-wrapper" class="flex-1 flex flex-col min-h-0 w-full relative">
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
            <!-- Screen Selection Tabs -->
            <div class="flex items-center bg-slate-950/60 p-1 rounded-xl border border-slate-800/80 space-x-1 mr-4">
                <button type="button" wire:click="setScreen('dashboard')" class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $currentScreen === 'dashboard' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200' }}">
                    Painel Geral
                </button>
                <button type="button" wire:click="setScreen('meses')" class="px-4 py-2 rounded-lg text-sm font-semibold transition {{ $currentScreen === 'meses' || $currentScreen === 'detalhes' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-400 hover:text-slate-200' }}">
                    Meus Meses
                </button>
            </div>

            <!-- Global Variables Quick View Badge -->
            <div class="hidden xl:flex items-center space-x-4 bg-slate-950/65 border border-slate-800/80 rounded-xl px-4 py-2 text-xs text-slate-400 select-none shadow-inner">
                <div class="flex items-center space-x-1.5">
                    <span class="text-slate-500 font-medium">Bolsa:</span>
                    <span class="font-bold text-slate-200 whitespace-nowrap">R$ {{ number_format($bolsa_auxilio, 2, ',', '.') }}</span>
                </div>
                <div class="border-l border-slate-800/80 h-3.5"></div>
                <div class="flex items-center space-x-1.5">
                    <span class="text-slate-500 font-medium">Alimentação/Dia:</span>
                    <span class="font-bold text-slate-200 whitespace-nowrap">R$ {{ number_format($alimentacao_dia, 2, ',', '.') }}</span>
                </div>
                <div class="border-l border-slate-800/80 h-3.5"></div>
                <div class="flex items-center space-x-1.5">
                    <span class="text-slate-500 font-medium">Transporte/Dia:</span>
                    <span class="font-bold text-slate-200 whitespace-nowrap">R$ {{ number_format($transporte_dia, 2, ',', '.') }}</span>
                </div>
                <div class="border-l border-slate-800/80 h-3.5"></div>
                <div class="flex items-center space-x-1.5">
                    <span class="text-slate-500 font-medium">Mãe Fixo:</span>
                    <span class="font-bold text-slate-200 whitespace-nowrap">R$ {{ number_format($dinheiro_mae, 2, ',', '.') }}</span>
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
            @if($currentScreen === 'dashboard')
                <div wire:key="screen-dashboard" class="space-y-6">
                    <!-- TELA 1: PAINEL GERAL (DASHBOARD COM GRÁFICOS) -->
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

                    <!-- Legenda de Cores e Indicadores -->
                    <div class="flex flex-wrap items-center justify-between gap-4 bg-slate-900/40 border border-slate-800/80 rounded-xl p-3.5 text-xs select-none">
                        <div class="flex items-center space-x-2 text-slate-400">
                            <svg class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-semibold text-slate-300">Legenda de Cores & Indicadores:</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                            <div class="flex items-center space-x-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-slate-300">Receitas / Entradas</span>
                            </div>
                            <div class="flex items-center space-x-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                                <span class="text-slate-300">Despesas / Saídas</span>
                            </div>
                            <div class="flex items-center space-x-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                <span class="text-slate-300">Total Mãe (Auxílios)</span>
                            </div>
                            <div class="flex items-center space-x-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
                                <span class="text-slate-300">Saldo Livre (Sobrou)</span>
                            </div>
                            <div class="flex items-center space-x-1.5 opacity-60">
                                <span class="h-2.5 w-2.5 rounded-full bg-slate-500 line-through"></span>
                                <span class="text-slate-400 line-through">Valores Ignorados</span>
                            </div>
                        </div>
                    </div>

                    <!-- Graphs Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Evolution Chart (Area) -->
                        <div class="lg:col-span-2 bg-slate-900/60 border border-slate-800 rounded-2xl p-6 shadow-xl" wire:ignore>
                            <h3 class="text-sm font-bold text-slate-200 uppercase tracking-wider mb-6">Evolução Mensal (Recebido vs Sobras)</h3>
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
                            <h3 class="text-sm font-bold text-slate-200 uppercase tracking-wider mb-6">Distribuição de Despesas & Reservas</h3>
                            <div x-data="{
                                caxinha: {{ $this->getChartTotalCaxinha() }},
                                investimento: {{ $this->getChartTotalInvestimento() }},
                                fatura: {{ $this->getChartTotalFatura() }},
                                mae: {{ $this->getChartTotalMae() }},
                                init() {
                                    let options = {
                                        chart: {
                                            type: 'donut',
                                            height: 320,
                                            foreColor: '#94a3b8'
                                        },
                                        theme: { mode: 'dark' },
                                        colors: ['#a855f7', '#6366f1', '#f43f5e', '#f59e0b'],
                                        series: [this.caxinha, this.investimento, this.fatura, this.mae],
                                        labels: ['Caxinha', 'Investimento', 'Fatura', 'Total Mãe'],
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-200">Sem dados para exibir gráficos</h3>
                            <p class="text-sm text-slate-400 mt-1">Configure os valores globais e adicione seu primeiro mês para carregar os gráficos.</p>
                        </div>
                        <button wire:click="openCreateModal" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-5 py-2 rounded-lg text-sm transition shadow-lg shadow-indigo-500/10">
                            Adicionar Mês
                        </button>
                    </div>
                @endif
                </div>

            @elseif($currentScreen === 'meses')
                <div wire:key="screen-meses" class="space-y-6">
                    <!-- TELA 2: LISTAGEM DE MESES SIMPLIFICADA -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-200">Minhas Finanças Mensais</h2>
                        <p class="text-xs text-slate-400">Selecione um mês para ver os detalhes completos ou editar</p>
                    </div>
                    <button wire:click="openCreateModal" class="flex items-center space-x-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 px-4 py-2 rounded-lg text-sm font-semibold text-white transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Adicionar Mês</span>
                    </button>
                </div>

                <div class="bg-slate-900/50 border border-slate-850 rounded-2xl p-6 shadow-xl relative overflow-x-auto min-h-[400px]">
                    @if(count($finances) === 0)
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 space-y-4">
                            <div class="h-16 w-16 bg-slate-900 border border-slate-800 rounded-full flex items-center justify-center text-slate-500 shadow-inner">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-200">Nenhum mês registrado ainda</h3>
                                <p class="text-sm text-slate-400 mt-1">Clique no botão acima para registrar seu primeiro mês.</p>
                            </div>
                        </div>
                    @else
                        <!-- Simplified Month Columns Grid -->
                        <div class="flex space-x-6 pb-4">
                            @foreach($finances as $finance)
                                <div wire:key="month-card-{{ $finance->id }}" class="flex-none w-72 bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-lg transition duration-200 hover:border-slate-700">
                                    <!-- Card Header -->
                                    <div class="bg-slate-950 border-b border-slate-800 px-4 py-3 flex items-center justify-between">
                                        <div>
                                            <h3 class="font-bold text-slate-200 text-sm leading-tight">{{ $finance->month_name }}</h3>
                                            <span class="text-[10px] text-slate-500">Trab: {{ $finance->month }}/{{ $finance->year }}</span>
                                        </div>
                                        <button onclick="confirm('Tem certeza que deseja excluir?') || event.stopImmediatePropagation()" wire:click="deleteFinance({{ $finance->id }})" class="p-1.5 text-slate-500 hover:text-rose-400 hover:bg-slate-850 rounded transition">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Rows (Theoretical, Received, Remaining) -->
                                    <div class="divide-y divide-slate-800/60 text-sm">
                                        <div class="px-4 py-3.5 flex justify-between bg-slate-900/30">
                                            <span class="text-slate-400 font-medium">Salário na Teoria:</span>
                                            <span class="font-semibold text-emerald-400">R$ {{ number_format($finance->salario_teorico, 2, ',', '.') }}</span>
                                        </div>
                                        <div class="px-4 py-3.5 flex justify-between">
                                            <span class="text-slate-400 font-medium">Recebido real:</span>
                                            <span class="font-semibold text-slate-200">R$ {{ number_format($finance->recebido, 2, ',', '.') }}</span>
                                        </div>
                                        <div class="px-4 py-3.5 flex justify-between bg-indigo-950/20">
                                            <span class="font-bold text-slate-300">Sobrou p/ mim:</span>
                                            <span class="font-bold text-indigo-400">R$ {{ number_format($finance->saldo_final, 2, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <!-- View Details / Edit Action -->
                                    <div class="px-4 py-3 bg-slate-950/60 border-t border-slate-800/60 text-center">
                                        <button wire:click="viewMonth({{ $finance->id }})" class="w-full py-1.5 bg-indigo-600 hover:bg-indigo-750 text-white text-xs font-semibold rounded-lg transition shadow-md shadow-indigo-600/10 flex items-center justify-center space-x-1">
                                            <span>Ver Completo / Editar</span>
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                </div>

            @elseif($currentScreen === 'detalhes' && $editingId)
                <div wire:key="screen-detalhes" class="space-y-6">
                    <!-- TELA 3: DETALHES COMPLETOS & EDIÇÃO DO MÊS SELECIONADO -->
                @php
                    $activeFinance = collect($finances)->firstWhere('id', $editingId);
                @endphp
                @if($activeFinance)
                    <div class="flex flex-col space-y-4">
                        <!-- Navigation / Title -->
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                            <div class="flex items-center space-x-3">
                                <button type="button" wire:click="setScreen('meses')" class="flex items-center space-x-1.5 px-3 py-1.5 bg-slate-900 border border-slate-800 hover:bg-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <span>Voltar para Listagem</span>
                                </button>
                                <h2 class="text-lg font-bold text-slate-100">
                                    Finanças Detalhadas: {{ $activeFinance->month_name }} / {{ $activeFinance->year }}
                                </h2>
                            </div>
                        </div>

                        <!-- Split Columns Layout -->
                        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                            <!-- Column 1: Details Read-Only -->
                            <div class="lg:col-span-2 space-y-4">
                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Detalhamento dos Valores</h3>
                                <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg divide-y divide-slate-800/60 text-sm">
                                    <!-- Salario Teórico -->
                                    <div class="px-4 py-3.5 flex flex-col justify-center bg-slate-900/30">
                                        <div class="flex justify-between w-full">
                                            <span class="text-slate-400 font-medium">Salário na Teoria:</span>
                                            <span class="font-semibold text-emerald-400">R$ {{ number_format($activeFinance->salario_teorico, 2, ',', '.') }}</span>
                                        </div>
                                        @if($activeFinance->ignorar_bolsa || $activeFinance->ignorar_alimentacao || $activeFinance->ignorar_transporte)
                                            <div class="flex flex-wrap items-center mt-1.5 text-[10px] text-slate-500 font-medium">
                                                <span class="text-slate-500 mr-2 text-[10px] uppercase font-semibold tracking-wider">Desconsiderou:</span>
                                                @if($activeFinance->ignorar_bolsa) <span class="bg-rose-950/40 text-rose-400 border border-rose-900/30 px-2 py-0.5 rounded text-[10px] mr-1.5 font-medium whitespace-nowrap">Bolsa</span> @endif
                                                @if($activeFinance->ignorar_alimentacao) <span class="bg-rose-950/40 text-rose-400 border border-rose-900/30 px-2 py-0.5 rounded text-[10px] mr-1.5 font-medium whitespace-nowrap">Alimentação</span> @endif
                                                @if($activeFinance->ignorar_transporte) <span class="bg-rose-950/40 text-rose-400 border border-rose-900/30 px-2 py-0.5 rounded text-[10px] mr-1.5 font-medium whitespace-nowrap">Transporte</span> @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Recebido real -->
                                    <div class="px-4 py-3.5 flex justify-between">
                                        <span class="text-slate-400">Recebido real:</span>
                                        <span class="font-semibold text-slate-200">R$ {{ number_format($activeFinance->recebido, 2, ',', '.') }}</span>
                                    </div>

                                    <!-- Dinheiro Mãe -->
                                    <div class="px-4 py-3.5 flex flex-col justify-center bg-slate-900/20">
                                        <div class="flex justify-between w-full">
                                            <span class="text-slate-400">Mãe:</span>
                                            <span class="font-semibold text-amber-500">R$ {{ number_format($activeFinance->total_mae, 2, ',', '.') }}</span>
                                        </div>
                                        @if($activeFinance->ignorar_dinheiro_mae || $activeFinance->ignorar_conducao)
                                            <div class="flex flex-wrap items-center mt-1.5 text-[10px] text-slate-500 font-medium">
                                                <span class="text-slate-500 mr-2 text-[10px] uppercase font-semibold tracking-wider">Desconsiderou:</span>
                                                @if($activeFinance->ignorar_dinheiro_mae) <span class="bg-rose-950/40 text-rose-400 border border-rose-900/30 px-2 py-0.5 rounded text-[10px] mr-1.5 font-medium whitespace-nowrap">Fixo</span> @endif
                                                @if($activeFinance->ignorar_conducao) <span class="bg-rose-950/40 text-rose-400 border border-rose-900/30 px-2 py-0.5 rounded text-[10px] mr-1.5 font-medium whitespace-nowrap">Condução</span> @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Caxinha -->
                                    <div class="px-4 py-3.5 flex justify-between items-center {{ $activeFinance->ignorar_caxinha ? 'opacity-40 bg-slate-900/10' : '' }}">
                                        <span class="text-slate-400 {{ $activeFinance->ignorar_caxinha ? 'line-through' : '' }}">Caxinha:</span>
                                        <span class="font-semibold {{ $activeFinance->ignorar_caxinha ? 'line-through text-slate-500' : 'text-violet-400' }}">
                                            R$ {{ number_format($activeFinance->caxinha, 2, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Investimento -->
                                    <div class="px-4 py-3.5 flex justify-between bg-slate-900/20 items-center {{ $activeFinance->ignorar_investimento ? 'opacity-40 bg-slate-900/10' : '' }}">
                                        <span class="text-slate-400 {{ $activeFinance->ignorar_investimento ? 'line-through' : '' }}">Investimento:</span>
                                        <span class="font-semibold {{ $activeFinance->ignorar_investimento ? 'line-through text-slate-500' : 'text-violet-400' }}">
                                            R$ {{ number_format($activeFinance->investimento, 2, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Fatura -->
                                    <div class="px-4 py-3.5 flex justify-between items-center {{ $activeFinance->ignorar_fatura ? 'opacity-40 bg-slate-900/10' : '' }}">
                                        <span class="text-slate-400 {{ $activeFinance->ignorar_fatura ? 'line-through' : '' }}">Fatura:</span>
                                        <span class="font-semibold {{ $activeFinance->ignorar_fatura ? 'line-through text-slate-500' : 'text-rose-400' }}">
                                            R$ {{ number_format($activeFinance->fatura, 2, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Coluna Extra -->
                                    @if($activeFinance->extra_valor > 0)
                                        <div class="px-4 py-3.5 flex justify-between bg-slate-900/10 items-center">
                                            <span class="text-slate-400 font-medium">{{ $activeFinance->extra_nome ?: 'Extra' }}:</span>
                                            <span class="font-semibold {{ $activeFinance->extra_tipo === 'entrada' ? 'text-emerald-400' : 'text-rose-400' }}">
                                                {{ $activeFinance->extra_tipo === 'entrada' ? '+' : '-' }} R$ {{ number_format($activeFinance->extra_valor, 2, ',', '.') }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Days stats -->
                                    <div class="px-4 py-3.5 flex justify-between">
                                        <span class="text-slate-400">Dias trabalhados:</span>
                                        <span class="font-medium text-slate-300">{{ $activeFinance->dias_trabalhados }}</span>
                                    </div>
                                    <div class="px-4 py-3.5 flex justify-between bg-slate-900/20">
                                        <span class="text-slate-400">Dias condução:</span>
                                        <span class="font-medium text-slate-300">{{ $activeFinance->dias_conducao }}</span>
                                    </div>
                                    <div class="px-4 py-3.5 flex justify-between">
                                        <span class="text-slate-400">Condução taxa:</span>
                                        <span class="font-medium text-slate-300">R$ {{ number_format($activeFinance->conducao_dia, 2, ',', '.') }}</span>
                                    </div>

                                    <!-- Sobrou final -->
                                    <div class="px-4 py-4 flex justify-between bg-indigo-950/20">
                                        <span class="font-bold text-slate-300 text-base">Sobrou p/ mim:</span>
                                        <span class="font-bold text-indigo-400 text-lg">R$ {{ number_format($activeFinance->saldo_final, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 2: Edit Form -->
                            <div class="lg:col-span-3 space-y-4">
                                <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-lg">
                                    <!-- Tabs Indicator inside details page -->
                                    <div class="flex border-b border-slate-800 bg-slate-950/50 text-sm select-none">
                                        <button type="button" wire:click="$set('formTab', 'basico')" class="flex-1 py-3 text-center font-semibold transition border-b-2 {{ $formTab === 'basico' ? 'text-indigo-400 border-indigo-500 bg-slate-900/50' : 'text-slate-400 border-transparent hover:text-slate-200' }}">
                                            1. Valores Básicos
                                        </button>
                                        <button type="button" wire:click="$set('formTab', 'avancado')" class="flex-1 py-3 text-center font-semibold transition border-b-2 {{ $formTab === 'avancado' ? 'text-indigo-400 border-indigo-500 bg-slate-900/50' : 'text-slate-400 border-transparent hover:text-slate-200' }}">
                                            2. Personalizar Cálculo (Ignorar & Extras)
                                        </button>
                                    </div>

                                    <form wire:submit.prevent="saveFinance" class="p-6 space-y-6">
                                        @if($formTab === 'basico')
                                            <div wire:key="details-tab-basico" class="space-y-6">
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
                                            </div>
                                        @else
                                            <div wire:key="details-tab-avancado" class="space-y-6">
                                                <!-- TELA 2: PARÂMETROS OPCIONAIS E EXTRAS -->

                                            <!-- Parâmetros Opcionais (Ignorar) -->
                                            <div class="space-y-3">
                                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Desconsiderar no Cálculo (Opcional)</h3>
                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-xs bg-slate-950/40 p-4 rounded-xl border border-slate-800/50">
                                                    <!-- Salário components -->
                                                    <div class="space-y-2">
                                                        <span class="text-slate-500 font-semibold uppercase tracking-wider text-[9px] block">No Salário</span>
                                                        <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                                            <input type="checkbox" wire:model.live="ignorar_bolsa" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                                            <span>Ignorar Bolsa</span>
                                                        </label>
                                                        <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                                            <input type="checkbox" wire:model.live="ignorar_alimentacao" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                                            <span>Ignorar Alim.</span>
                                                        </label>
                                                        <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                                            <input type="checkbox" wire:model.live="ignorar_transporte" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                                            <span>Ignorar Transp.</span>
                                                        </label>
                                                    </div>
                                                    
                                                    <!-- Mãe components -->
                                                    <div class="space-y-2 border-l border-slate-850 pl-3">
                                                        <span class="text-slate-500 font-semibold uppercase tracking-wider text-[9px] block">Na Mãe</span>
                                                        <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                                            <input type="checkbox" wire:model.live="ignorar_dinheiro_mae" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                                            <span>Ignorar M. Fixo</span>
                                                        </label>
                                                        <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                                            <input type="checkbox" wire:model.live="ignorar_conducao" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                                            <span>Ignorar Cond.</span>
                                                        </label>
                                                    </div>

                                                    <!-- Balance columns -->
                                                    <div class="space-y-2 border-l border-slate-850 pl-3 col-span-2 md:col-span-1">
                                                        <span class="text-slate-500 font-semibold uppercase tracking-wider text-[9px] block">Nas Despesas</span>
                                                        <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                                            <input type="checkbox" wire:model.live="ignorar_caxinha" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                                            <span>Ignorar Caxinha</span>
                                                        </label>
                                                        <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                                            <input type="checkbox" wire:model.live="ignorar_investimento" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                                            <span>Ignorar Invest.</span>
                                                        </label>
                                                        <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                                            <input type="checkbox" wire:model.live="ignorar_fatura" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                                            <span>Ignorar Fatura</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Coluna Customizada Extra -->
                                            <div class="space-y-3">
                                                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Adicionar Campo/Valor Extra no Total</h3>
                                                <div class="grid grid-cols-3 gap-4 bg-slate-950/40 p-4 rounded-xl border border-slate-800/50">
                                                    <div>
                                                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Nome do Campo</label>
                                                        <input type="text" wire:model.live="extra_nome" placeholder="Ex: Bônus" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100">
                                                        @error('extra_nome') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Tipo</label>
                                                        <select wire:model.live="extra_tipo" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100">
                                                            <option value="saida">Saída (Despesa)</option>
                                                            <option value="entrada">Entrada (Receita)</option>
                                                        </select>
                                                        @error('extra_tipo') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Valor (R$)</label>
                                                        <input type="number" step="0.01" wire:model.live="extra_valor" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100">
                                                        @error('extra_valor') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        @endif

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
                                            <!-- Footer Action Buttons -->
                                            <div class="flex items-center justify-end pt-4 border-t border-slate-850 space-x-3">
                                                <button type="button" wire:click="setScreen('meses')" class="px-5 py-2 border border-slate-800 hover:bg-slate-850 rounded-lg text-sm font-semibold text-slate-300 hover:text-slate-100 transition duration-200">
                                                    Cancelar
                                                </button>
                                                <button type="submit" class="px-5 py-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold rounded-lg text-sm transition shadow-lg shadow-indigo-500/10 active:scale-[0.98]">
                                                    Salvar Alterações
                                                </button>
                                             </div>
                                     </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            @endif
        </div>
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

                <!-- Tabs / Etapas para Reorganização UI/UX -->
                <div class="flex border-b border-slate-800 bg-slate-950/50 text-sm select-none">
                    <button type="button" wire:click="$set('formTab', 'basico')" class="flex-1 py-3 text-center font-semibold transition border-b-2 {{ $formTab === 'basico' ? 'text-indigo-400 border-indigo-500 bg-slate-900/50' : 'text-slate-400 border-transparent hover:text-slate-200' }}">
                        1. Valores Básicos
                    </button>
                    <button type="button" wire:click="$set('formTab', 'avancado')" class="flex-1 py-3 text-center font-semibold transition border-b-2 {{ $formTab === 'avancado' ? 'text-indigo-400 border-indigo-500 bg-slate-900/50' : 'text-slate-400 border-transparent hover:text-slate-200' }}">
                        2. Personalizar Cálculo (Ignorar & Extras)
                    </button>
                </div>

                <form wire:submit.prevent="saveFinance" class="p-6 space-y-4">
                    @if($formTab === 'basico')
                        <div wire:key="modal-tab-basico" class="space-y-4">
                            <!-- TELA 1: VALORES BÁSICOS -->
                        
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
                        </div>
                    @else
                        <div wire:key="modal-tab-avancado" class="space-y-4">
                            <!-- TELA 2: PARÂMETROS OPCIONAIS E EXTRAS -->

                        <!-- Parâmetros Opcionais (Ignorar) -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Desconsiderar no Cálculo (Opcional)</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-xs bg-slate-950/40 p-4 rounded-xl border border-slate-800/50">
                                <!-- Salário components -->
                                <div class="space-y-2">
                                    <span class="text-slate-500 font-semibold uppercase tracking-wider text-[9px] block">No Salário</span>
                                    <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                        <input type="checkbox" wire:model.live="ignorar_bolsa" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                        <span>Ignorar Bolsa</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                        <input type="checkbox" wire:model.live="ignorar_alimentacao" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                        <span>Ignorar Alim.</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                        <input type="checkbox" wire:model.live="ignorar_transporte" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                        <span>Ignorar Transp.</span>
                                    </label>
                                </div>
                                
                                <!-- Mãe components -->
                                <div class="space-y-2 border-l border-slate-850 pl-3">
                                    <span class="text-slate-500 font-semibold uppercase tracking-wider text-[9px] block">Na Mãe</span>
                                    <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                        <input type="checkbox" wire:model.live="ignorar_dinheiro_mae" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                        <span>Ignorar M. Fixo</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                        <input type="checkbox" wire:model.live="ignorar_conducao" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                        <span>Ignorar Cond.</span>
                                    </label>
                                </div>

                                <!-- Balance columns -->
                                <div class="space-y-2 border-l border-slate-850 pl-3 col-span-2 md:col-span-1">
                                    <span class="text-slate-500 font-semibold uppercase tracking-wider text-[9px] block">Nas Despesas</span>
                                    <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                        <input type="checkbox" wire:model.live="ignorar_caxinha" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                        <span>Ignorar Caxinha</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                        <input type="checkbox" wire:model.live="ignorar_investimento" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                        <span>Ignorar Invest.</span>
                                    </label>
                                    <label class="flex items-center space-x-2 text-slate-300 cursor-pointer hover:text-slate-100">
                                        <input type="checkbox" wire:model.live="ignorar_fatura" class="rounded border-slate-800 bg-slate-950 text-indigo-500 focus:ring-0 focus:ring-offset-0">
                                        <span>Ignorar Fatura</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna Customizada Extra -->
                        <div class="space-y-3">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Adicionar Campo/Valor Extra no Total</h3>
                            <div class="grid grid-cols-3 gap-4 bg-slate-950/40 p-4 rounded-xl border border-slate-800/50">
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Nome do Campo</label>
                                    <input type="text" wire:model.live="extra_nome" placeholder="Ex: Bônus" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100">
                                    @error('extra_nome') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Tipo</label>
                                    <select wire:model.live="extra_tipo" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100">
                                        <option value="saida">Saída (Despesa)</option>
                                        <option value="entrada">Entrada (Receita)</option>
                                    </select>
                                    @error('extra_tipo') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Valor (R$)</label>
                                    <input type="number" step="0.01" wire:model.live="extra_valor" class="w-full bg-slate-950 border border-slate-800 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:border-indigo-500 text-slate-100">
                                    @error('extra_valor') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        </div>
                    @endif

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

                    <!-- Footer Action Buttons -->
                    <div class="flex items-center justify-end pt-4 border-t border-slate-850 space-x-3">
                        <button type="button" wire:click="$set('showFormModal', false)" class="px-5 py-2 border border-slate-800 hover:bg-slate-850 rounded-lg text-sm font-semibold text-slate-300 hover:text-slate-100 transition duration-200">
                            Cancelar
                        </button>
                        <button type="submit" class="px-5 py-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold rounded-lg text-sm transition shadow-lg shadow-indigo-500/10 active:scale-[0.98]">
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
    </div>
    @endif
</div>
