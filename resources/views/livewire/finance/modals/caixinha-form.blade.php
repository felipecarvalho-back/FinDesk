<!-- MODAL: CRIAR / EDITAR CAIXINHA -->
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
