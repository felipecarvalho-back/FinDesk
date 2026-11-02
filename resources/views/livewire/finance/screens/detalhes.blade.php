<!-- TELA 3: DETALHES DO MÊS -->
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
