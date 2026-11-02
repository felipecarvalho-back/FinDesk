<!-- TELA 4: CAIXINHAS -->
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
