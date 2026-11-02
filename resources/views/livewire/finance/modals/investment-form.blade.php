<!-- MODAL: CRIAR / EDITAR INVESTIMENTO -->
@if($showInvestmentModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
        <div class="bg-slate-900 border border-slate-800/90 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            {{-- Modal Header --}}
            <div class="px-5 py-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/40">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-violet-500/15 border border-violet-500/20 text-violet-400 flex items-center justify-center shrink-0">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-100">
                            {{ $investmentId ? 'Editar Investimento' : 'Novo Investimento' }}
                        </h3>
                        <p class="text-xs text-slate-400">Cadastre ou atualize a posição do ativo</p>
                    </div>
                </div>
                <button type="button" wire:click="$set('showInvestmentModal', false)"
                    class="text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 rounded-lg p-1.5 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form wire:submit.prevent="saveInvestment" class="p-5 space-y-3.5">
                <div wire:key="inv-field-name" class="space-y-1">
                    <label for="investment_name" class="block text-xs font-semibold text-slate-300">Nome do Ativo / Aplicação</label>
                    <input type="text" id="investment_name" name="investmentName" wire:key="input-investment-name" wire:model="investmentName" placeholder="ex: CDB 100% CDI, Tesouro Selic, Bitcoin"
                        class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3.5 py-2 text-sm text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition" required>
                    @error('investmentName') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div wire:key="inv-field-cat" class="space-y-1">
                        <label for="investment_cat" class="block text-xs font-semibold text-slate-300">Categoria</label>
                        <select id="investment_cat" name="investmentCategory" wire:key="input-investment-category" wire:model="investmentCategory"
                            class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3 py-2 text-xs font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                            <option value="Renda Fixa">Renda Fixa (CDB/LCI)</option>
                            <option value="Tesouro Direto">Tesouro Direto</option>
                            <option value="Ações">Ações</option>
                            <option value="Fundos Imobiliários">FIIs</option>
                            <option value="Criptomoedas">Cripto</option>
                            <option value="Fundos de Investimento">Fundos</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                    <div wire:key="inv-field-inst" class="space-y-1">
                        <label for="investment_inst" class="block text-xs font-semibold text-slate-300">Instituição</label>
                        <input type="text" id="investment_inst" name="investmentInstitution" wire:key="input-investment-institution" wire:model="investmentInstitution" placeholder="ex: Nubank, XP"
                            class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                    </div>
                </div>
                <div wire:key="inv-field-amount" class="space-y-1">
                    <label for="investment_amount" class="block text-xs font-semibold text-slate-300">Valor Investido</label>
                    <div class="relative rounded-xl shadow-sm">
                        <span class="absolute left-3.5 top-2.5 text-sm font-semibold text-slate-500 pointer-events-none">R$</span>
                        <input type="number" step="0.01" id="investment_amount" name="investmentAmount" wire:key="input-investment-amount" wire:model="investmentAmount" placeholder="0.00"
                            class="w-full bg-slate-950/80 border border-slate-800 rounded-xl pl-9 pr-3.5 py-2.5 text-sm font-bold text-violet-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" required>
                    </div>
                </div>
                <div wire:key="inv-field-notes" class="space-y-1">
                    <label for="investment_notes" class="block text-xs font-semibold text-slate-300">Notas / Detalhes <span class="text-slate-500 font-normal">(opcional)</span></label>
                    <input type="text" id="investment_notes" name="investmentNotes" wire:key="input-investment-notes" wire:model="investmentNotes" placeholder="ex: Vencimento 2027, Liquidez diária"
                        class="w-full bg-slate-950/80 border border-slate-800 rounded-xl px-3.5 py-2 text-sm text-slate-100 placeholder:text-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                </div>
                <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-800/60">
                    <button type="button" wire:click="$set('showInvestmentModal', false)"
                        class="px-4 py-2 bg-slate-800/80 hover:bg-slate-700 active:scale-95 text-slate-300 rounded-xl text-xs font-semibold transition">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-violet-600 hover:bg-violet-500 active:scale-95 text-white rounded-xl text-xs font-semibold shadow-lg shadow-violet-600/25 transition">
                        Salvar Investimento
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
