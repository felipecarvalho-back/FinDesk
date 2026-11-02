<!-- MODAL: CRIAR / EDITAR MÊS -->
@if($showFormModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 overflow-y-auto">
        <div class="bg-slate-900 border border-slate-800/90 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden my-6 animate-in fade-in zoom-in-95 duration-150">
            {{-- Modal Header --}}
            <div class="px-5 py-4 border-b border-slate-800/80 flex items-center justify-between bg-slate-950/40">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-indigo-500/15 border border-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-100">
                            {{ $editingId ? 'Editar Registro Financeiro' : 'Novo Registro Mensal' }}
                        </h3>
                        <p class="text-xs text-slate-400">Preencha os dados do mês e configure despesas/repasses</p>
                    </div>
                </div>
                <button type="button" wire:click="$set('showFormModal', false)"
                    class="text-slate-400 hover:text-slate-200 hover:bg-slate-800/60 rounded-lg p-1.5 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Form Modal Tabs (Segmented Control) --}}
            <div class="px-5 pt-4 pb-1">
                <div class="flex items-center bg-slate-950/90 p-1 rounded-xl border border-slate-800/80 shadow-inner gap-1">
                    <button type="button" wire:click="$set('formTab', 'basico')"
                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5 {{ $formTab === 'basico' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                        <span>1. Receitas & Dias</span>
                        @if($errors->hasAny(['month', 'year', 'dias_trabalhados', 'recebido']))
                            <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                        @endif
                    </button>
                    <button type="button" wire:click="$set('formTab', 'despesas')"
                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5 {{ $formTab === 'despesas' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                        <span>2. Despesas</span>
                        @if($errors->hasAny(['conducao_dia', 'dias_conducao', 'caxinha', 'investimento', 'fatura', 'internet', 'gemini']))
                            <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                        @endif
                    </button>
                    <button type="button" wire:click="$set('formTab', 'extras')"
                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-1.5 {{ $formTab === 'extras' ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60' }}">
                        <span>3. Extras & Ignorar</span>
                        @if($errors->hasAny(['extra_valor', 'extra_nome', 'extra_tipo']))
                            <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                        @endif
                    </button>
                </div>
            </div>

            <form wire:submit.prevent="saveFinance" class="p-5 space-y-4">
                @if($errors->any())
                    <div class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-xl text-xs text-rose-300 space-y-1">
                        <p class="font-bold flex items-center gap-1.5 text-rose-400">
                            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>Corrija os campos com erro para salvar:</span>
                        </p>
                        <ul class="list-disc list-inside text-[11px] text-rose-300/90 pl-1 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- TAB 1: BÁSICO (RECEITAS & DIAS) --}}
                <div wire:key="container-tab-basico" class="{{ $formTab === 'basico' ? 'space-y-3.5' : 'hidden' }}">
                    <div class="grid grid-cols-2 gap-3.5">
                        <div wire:key="field-wrapper-month" class="space-y-1">
                            <label for="field_month" class="block text-xs font-semibold text-slate-300">Mês de Referência</label>
                            <select id="field_month" name="month" wire:key="input-field-month" wire:model="month"
                                class="w-full bg-slate-950/80 border {{ $errors->has('month') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}">{{ \Carbon\Carbon::create(2026, $m, 1)->locale('pt_BR')->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                            @error('month') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-year" class="space-y-1">
                            <label for="field_year" class="block text-xs font-semibold text-slate-300">Ano</label>
                            <input type="number" id="field_year" name="year" wire:key="input-field-year" wire:model="year"
                                class="w-full bg-slate-950/80 border {{ $errors->has('year') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            @error('year') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-dias-trabalhados" class="space-y-1">
                            <label for="field_dias_trabalhados" class="block text-xs font-semibold text-slate-300">Dias Trabalhados</label>
                            <input type="number" id="field_dias_trabalhados" name="dias_trabalhados" wire:key="input-field-dias-trabalhados" wire:model="dias_trabalhados" placeholder="ex: 20"
                                class="w-full bg-slate-950/80 border {{ $errors->has('dias_trabalhados') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            @error('dias_trabalhados') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-recebido" class="space-y-1">
                            <label for="field_recebido" class="block text-xs font-semibold text-slate-300">Recebido Real</label>
                            <div class="relative rounded-xl shadow-sm">
                                <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                <input type="number" step="0.01" id="field_recebido" name="recebido" wire:key="input-field-recebido" wire:model="recebido"
                                    class="w-full bg-slate-950/80 border {{ $errors->has('recebido') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-bold text-emerald-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            <span class="text-[10px] text-slate-500 block mt-0.5">Sugerido: R$ {{ number_format($previewSalarioTeorico, 2, ',', '.') }}</span>
                            @error('recebido') <span class="text-rose-400 text-[10px] block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- TAB 2: DESPESAS --}}
                <div wire:key="container-tab-despesas" class="{{ $formTab === 'despesas' ? 'space-y-3.5' : 'hidden' }}">
                    <div class="grid grid-cols-2 gap-3.5">
                        <div wire:key="field-wrapper-conducao-dia" class="space-y-1">
                            <label for="field_conducao_dia" class="block text-xs font-semibold text-slate-300">Condução / Dia Mãe</label>
                            <div class="relative rounded-xl shadow-sm">
                                <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                <input type="number" step="0.01" id="field_conducao_dia" name="conducao_dia" wire:key="input-field-conducao-dia" wire:model="conducao_dia"
                                    class="w-full bg-slate-950/80 border {{ $errors->has('conducao_dia') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            @error('conducao_dia') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-dias-conducao" class="space-y-1">
                            <label for="field_dias_conducao" class="block text-xs font-semibold text-slate-300">Dias Condução Mãe</label>
                            <input type="number" id="field_dias_conducao" name="dias_conducao" wire:key="input-field-dias-conducao" wire:model="dias_conducao" placeholder="ex: 20"
                                class="w-full bg-slate-950/80 border {{ $errors->has('dias_conducao') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl px-3.5 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            @error('dias_conducao') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-caxinha" class="space-y-1">
                            <label for="field_caxinha" class="block text-xs font-semibold text-slate-300">Caixinha</label>
                            <div class="relative rounded-xl shadow-sm">
                                <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                <input type="number" step="0.01" id="field_caxinha" name="caxinha" wire:key="input-field-caxinha" wire:model="caxinha"
                                    class="w-full bg-slate-950/80 border {{ $errors->has('caxinha') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            @error('caxinha') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-investimento" class="space-y-1">
                            <label for="field_investimento" class="block text-xs font-semibold text-slate-300">Investimento</label>
                            <div class="relative rounded-xl shadow-sm">
                                <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                <input type="number" step="0.01" id="field_investimento" name="investimento" wire:key="input-field-investimento" wire:model="investimento"
                                    class="w-full bg-slate-950/80 border {{ $errors->has('investimento') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            @error('investimento') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-fatura" class="space-y-1">
                            <label for="field_fatura" class="block text-xs font-semibold text-slate-300">Fatura Cartão</label>
                            <div class="relative rounded-xl shadow-sm">
                                <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                <input type="number" step="0.01" id="field_fatura" name="fatura" wire:key="input-field-fatura" wire:model="fatura"
                                    class="w-full bg-slate-950/80 border {{ $errors->has('fatura') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-rose-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            @error('fatura') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-internet" class="space-y-1">
                            <label for="field_internet" class="block text-xs font-semibold text-slate-300">Internet</label>
                            <div class="relative rounded-xl shadow-sm">
                                <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                <input type="number" step="0.01" id="field_internet" name="internet" wire:key="input-field-internet" wire:model="internet"
                                    class="w-full bg-slate-950/80 border {{ $errors->has('internet') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            @error('internet') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div wire:key="field-wrapper-gemini" class="col-span-2 space-y-1">
                            <label for="field_gemini" class="block text-xs font-semibold text-slate-300">Gemini AI</label>
                            <div class="relative rounded-xl shadow-sm">
                                <span class="absolute left-3 top-2 text-xs font-semibold text-slate-500 pointer-events-none">R$</span>
                                <input type="number" step="0.01" id="field_gemini" name="gemini" wire:key="input-field-gemini" wire:model="gemini"
                                    class="w-full bg-slate-950/80 border {{ $errors->has('gemini') ? 'border-rose-500' : 'border-slate-800' }} rounded-xl pl-8 pr-3 py-2 text-sm font-semibold text-slate-100 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            @error('gemini') <span class="text-rose-400 text-[10px] block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- TAB 3: EXTRAS & IGNORAR --}}
                <div wire:key="container-tab-extras" class="{{ $formTab === 'extras' ? 'space-y-3.5' : 'hidden' }}">
                    <div class="space-y-3.5">
                        <div class="bg-slate-950/70 p-3.5 rounded-xl border border-slate-800/80 space-y-2.5">
                            <span class="text-[11px] font-bold text-slate-400 block uppercase tracking-wider">Ignorar Despesas no Cálculo</span>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_bolsa" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar Bolsa</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_alimentacao" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar VR</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_transporte" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar VT</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_dinheiro_mae" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar Mãe Fixo</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_conducao" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar Condução</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_caxinha" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar Caixinha</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_investimento" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar Investimento</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_fatura" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar Fatura</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_internet" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar Internet</span>
                                </label>
                                <label class="flex items-center space-x-2 text-slate-300 hover:text-white cursor-pointer bg-slate-900/60 border border-slate-800/60 rounded-lg px-2.5 py-1.5 transition">
                                    <input type="checkbox" wire:model.live="ignorar_gemini" class="rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-0">
                                    <span>Ignorar Gemini</span>
                                </label>
                            </div>
                        </div>

                        <div class="bg-slate-950/70 p-3.5 rounded-xl border border-slate-800/80 space-y-2.5">
                            <span class="text-[11px] font-bold text-slate-400 block uppercase tracking-wider">Lançamento Extra (Opcional)</span>
                            <div class="grid grid-cols-3 gap-2.5">
                                <div wire:key="field-wrapper-extra-nome" class="space-y-1">
                                    <label for="field_extra_nome" class="block text-[10px] font-semibold text-slate-400">Nome</label>
                                    <input type="text" id="field_extra_nome" name="extra_nome" wire:key="input-field-extra-nome" wire:model="extra_nome" placeholder="ex: Bônus"
                                        class="w-full bg-slate-900/80 border border-slate-800 rounded-lg px-2.5 py-1.5 text-xs text-slate-100 focus:border-indigo-500 focus:outline-none">
                                </div>
                                <div wire:key="field-wrapper-extra-valor" class="space-y-1">
                                    <label for="field_extra_valor" class="block text-[10px] font-semibold text-slate-400">Valor (R$)</label>
                                    <input type="number" step="0.01" id="field_extra_valor" name="extra_valor" wire:key="input-field-extra-valor" wire:model="extra_valor" placeholder="0.00"
                                        class="w-full bg-slate-900/80 border border-slate-800 rounded-lg px-2.5 py-1.5 text-xs text-slate-100 focus:border-indigo-500 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </div>
                                <div wire:key="field-wrapper-extra-tipo" class="space-y-1">
                                    <label for="field_extra_tipo" class="block text-[10px] font-semibold text-slate-400">Tipo</label>
                                    <select id="field_extra_tipo" name="extra_tipo" wire:key="input-field-extra-tipo" wire:model="extra_tipo"
                                        class="w-full bg-slate-900/80 border border-slate-800 rounded-lg px-2 py-1.5 text-xs text-slate-100 focus:border-indigo-500 focus:outline-none">
                                        <option value="saida">Saída (-)</option>
                                        <option value="entrada">Entrada (+)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Calculation Preview Card in Modal --}}
                <div class="bg-slate-950/90 p-3.5 rounded-xl border border-slate-800/80 flex items-center justify-between text-xs shadow-inner">
                    <div>
                        <span class="text-[11px] text-slate-400 block font-medium">Total Mãe Previsto</span>
                        <span class="font-bold text-amber-400 text-sm">R$ {{ number_format($previewMae, 2, ',', '.') }}</span>
                    </div>
                    <div class="border-l border-slate-800 h-7"></div>
                    <div class="text-right">
                        <span class="text-[11px] text-slate-400 block font-medium">Saldo Livre Previsto</span>
                        <span class="font-bold text-sm {{ $previewSaldoFinal >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                            R$ {{ number_format($previewSaldoFinal, 2, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-800/60">
                    <button type="button" wire:click="$set('showFormModal', false)"
                        class="px-4 py-2 bg-slate-800/80 hover:bg-slate-700 active:scale-95 text-slate-300 rounded-xl text-xs font-semibold transition">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 active:scale-95 text-white rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/25 transition">
                        Salvar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
