<!-- TELA 5: INVESTIMENTOS -->
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
