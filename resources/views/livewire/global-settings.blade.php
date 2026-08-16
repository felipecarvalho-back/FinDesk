<div class="h-screen flex flex-col bg-[#0f1117] text-slate-100 overflow-hidden">

    {{-- Titlebar / Drag Region --}}
    <div style="-webkit-app-region: drag;" class="shrink-0 h-10 bg-[#0c0e15] border-b border-white/[0.07] flex items-center px-4 gap-2.5">
        <div class="h-5 w-5 rounded-md bg-indigo-500/20 flex items-center justify-center shrink-0">
            <svg class="h-3 w-3 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <span class="text-[11px] font-semibold text-slate-500 tracking-wide select-none">Valores Globais Padrão</span>
    </div>

    {{-- Success Banner --}}
    @if($saved)
        <div class="shrink-0 flex items-center gap-2.5 px-4 py-2.5 bg-emerald-500/10 border-b border-emerald-500/20">
            <div class="h-4 w-4 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                <svg class="h-2.5 w-2.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-emerald-400">Valores salvos com sucesso</p>
            <button type="button" wire:click="$set('saved', false)"
                class="ml-auto text-emerald-600 hover:text-emerald-400 transition-colors">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- Body Form --}}
    <form wire:submit.prevent="save" class="flex-1 flex flex-col overflow-hidden">

        {{-- Fields --}}
        <div class="flex-1 overflow-y-auto px-4 py-3 space-y-4">

            {{-- Renda --}}
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-600 mb-2">Renda</p>
                <div class="rounded-xl border border-white/[0.07] overflow-hidden divide-y divide-white/[0.07]">
                    <div class="flex items-center bg-slate-900/40 hover:bg-slate-900/70 transition-colors px-4 py-3 gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-200">Bolsa Auxílio</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Valor base mensal</p>
                        </div>
                        <div class="flex items-center gap-0 shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500/20 transition-all">
                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none shrink-0">R$</span>
                            <input type="number" step="0.01" wire:model="bolsa_auxilio"
                                class="flex-1 min-w-0 bg-transparent py-1.5 pr-2.5 text-sm font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                </div>
                @error('bolsa_auxilio')
                    <p class="text-rose-400 text-[10px] mt-1 px-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Despesas Fixas --}}
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-600 mb-2">Despesas Fixas</p>
                <div class="rounded-xl border border-white/[0.07] overflow-hidden divide-y divide-white/[0.07]">

                    <div class="flex items-center bg-slate-900/40 hover:bg-slate-900/70 transition-colors px-4 py-3 gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-200">Dinheiro Mãe</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Repasse mensal fixo</p>
                        </div>
                        <div class="flex items-center gap-0 shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500/20 transition-all">
                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none shrink-0">R$</span>
                            <input type="number" step="0.01" wire:model="dinheiro_mae"
                                class="flex-1 min-w-0 bg-transparent py-1.5 pr-2.5 text-sm font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                    @error('dinheiro_mae')
                        <p class="text-rose-400 text-[10px] px-4 py-1">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center bg-slate-900/40 hover:bg-slate-900/70 transition-colors px-4 py-3 gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-200">Internet</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Plano mensal</p>
                        </div>
                        <div class="flex items-center gap-0 shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500/20 transition-all">
                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none shrink-0">R$</span>
                            <input type="number" step="0.01" wire:model="internet_padrao"
                                class="flex-1 min-w-0 bg-transparent py-1.5 pr-2.5 text-sm font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                    @error('internet_padrao')
                        <p class="text-rose-400 text-[10px] px-4 py-1">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center bg-slate-900/40 hover:bg-slate-900/70 transition-colors px-4 py-3 gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-200">Gemini AI</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Assinatura mensal</p>
                        </div>
                        <div class="flex items-center gap-0 shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500/20 transition-all">
                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none shrink-0">R$</span>
                            <input type="number" step="0.01" wire:model="gemini_padrao"
                                class="flex-1 min-w-0 bg-transparent py-1.5 pr-2.5 text-sm font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                    @error('gemini_padrao')
                        <p class="text-rose-400 text-[10px] px-4 py-1">{{ $message }}</p>
                    @enderror

                </div>
            </div>

            {{-- Custos Diários --}}
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-600 mb-2">Custos Diários</p>
                <div class="rounded-xl border border-white/[0.07] overflow-hidden divide-y divide-white/[0.07]">

                    <div class="flex items-center bg-slate-900/40 hover:bg-slate-900/70 transition-colors px-4 py-3 gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-200">Alimentação / VR</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Refeição por dia útil</p>
                        </div>
                        <div class="flex items-center gap-0 shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500/20 transition-all">
                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none shrink-0">R$</span>
                            <input type="number" step="0.01" wire:model="alimentacao_dia"
                                class="flex-1 min-w-0 bg-transparent py-1.5 pr-2.5 text-sm font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                    @error('alimentacao_dia')
                        <p class="text-rose-400 text-[10px] px-4 py-1">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center bg-slate-900/40 hover:bg-slate-900/70 transition-colors px-4 py-3 gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-slate-200">Transporte / VT</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Passagem por dia útil</p>
                        </div>
                        <div class="flex items-center gap-0 shrink-0 w-32 bg-slate-800/60 border border-white/[0.08] rounded-lg overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500/20 transition-all">
                            <span class="pl-2.5 pr-1 text-[11px] font-semibold text-slate-500 select-none shrink-0">R$</span>
                            <input type="number" step="0.01" wire:model="transporte_dia"
                                class="flex-1 min-w-0 bg-transparent py-1.5 pr-2.5 text-sm font-bold text-slate-100 text-right focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>
                    @error('transporte_dia')
                        <p class="text-rose-400 text-[10px] px-4 py-1">{{ $message }}</p>
                    @enderror

                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="shrink-0 border-t border-white/[0.06] bg-[#0c0e15] px-4 py-3 flex items-center justify-end gap-2">
            <button type="button" wire:click="closeWindow"
                class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:text-slate-200 hover:bg-white/[0.06] transition-colors">
                Fechar
            </button>
            <button type="submit"
                class="px-4 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors active:scale-[0.97]">
                Salvar Alterações
            </button>
        </div>

    </form>

</div>
