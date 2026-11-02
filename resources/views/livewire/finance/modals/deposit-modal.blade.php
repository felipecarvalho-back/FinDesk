<!-- MODAL: DEPÓSITO / RESGATE EM CAIXINHA -->
@if($showDepositModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
        <div class="bg-slate-900 border border-slate-800/90 rounded-2xl w-full max-w-sm shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            {{-- Modal Header --}}
            <div class="px-5 py-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/40">
                <div>
                    <h3 class="text-sm font-bold text-slate-100">
                        {{ $depositActionType === 'deposito' ? 'Guardar Dinheiro' : 'Resgatar Dinheiro' }}
                    </h3>
                    <p class="text-xs text-slate-400">Informe o valor da movimentação</p>
                </div>
                <button type="button" wire:click="$set('showDepositModal', false)"
                    class="text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 rounded-lg p-1.5 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form wire:submit.prevent="processDepositAction" class="p-5 space-y-3.5">
                {{-- Action Switcher --}}
                <div class="flex p-1 bg-slate-950 rounded-xl border border-slate-800/80 gap-1">
                    <button type="button" wire:click="$set('depositActionType', 'deposito')"
                        class="flex-1 py-1.5 text-xs font-semibold rounded-lg transition {{ $depositActionType === 'deposito' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200' }}">
                        + Guardar
                    </button>
                    <button type="button" wire:click="$set('depositActionType', 'resgate')"
                        class="flex-1 py-1.5 text-xs font-semibold rounded-lg transition {{ $depositActionType === 'resgate' ? 'bg-rose-600 text-white shadow-sm shadow-rose-600/30' : 'text-slate-400 hover:text-slate-200' }}">
                        - Resgatar
                    </button>
                </div>

                <div wire:key="deposit-field-amount" class="space-y-1">
                    <label for="deposit_amount" class="block text-xs font-semibold text-slate-300">Valor da Operação</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute left-3.5 top-2.5 text-sm font-semibold text-slate-500 pointer-events-none">R$</span>
                        <input type="number" step="0.01" id="deposit_amount" name="depositAmount" wire:key="input-deposit-amount" wire:model="depositAmount" placeholder="0.00"
                            class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-9 pr-3.5 py-2.5 text-base font-bold text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" required autofocus>
                    </div>
                    @error('depositAmount') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-4 gap-1.5 pt-0.5">
                    <button type="button" wire:click="$set('depositAmount', 20)" class="py-1.5 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition active:scale-95">+ R$ 20</button>
                    <button type="button" wire:click="$set('depositAmount', 50)" class="py-1.5 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition active:scale-95">+ R$ 50</button>
                    <button type="button" wire:click="$set('depositAmount', 100)" class="py-1.5 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition active:scale-95">+ R$ 100</button>
                    <button type="button" wire:click="$set('depositAmount', 200)" class="py-1.5 bg-slate-950/80 hover:bg-slate-800 border border-slate-800 rounded-lg text-xs font-semibold text-slate-300 transition active:scale-95">+ R$ 200</button>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-800/60">
                    <button type="button" wire:click="$set('showDepositModal', false)"
                        class="px-4 py-2 bg-slate-800/80 hover:bg-slate-700 active:scale-95 text-slate-300 rounded-xl text-xs font-semibold transition">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-5 py-2 {{ $depositActionType === 'deposito' ? 'bg-indigo-600 hover:bg-indigo-500 shadow-indigo-600/25' : 'bg-rose-600 hover:bg-rose-500 shadow-rose-600/25' }} text-white rounded-xl text-xs font-semibold shadow-lg transition active:scale-95">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
