<!-- TELA 1: PAINEL GERAL (DASHBOARD) -->
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

            <!-- Top Metrics Cards -->
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
