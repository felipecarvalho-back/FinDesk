<!-- TELA 2: MEUS MESES -->
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
