<!-- MODAL: CONFIGURAÇÕES GLOBAIS (FALLBACK WEB) -->
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
