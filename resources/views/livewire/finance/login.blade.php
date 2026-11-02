<!-- Tela de Login -->
<div class="flex-1 flex flex-col justify-center items-center px-4 py-16 bg-slate-950">
    <div class="w-full max-w-sm bg-slate-900 border border-slate-800/80 p-8 rounded-2xl shadow-2xl text-center space-y-6">
        <div class="mx-auto h-12 w-12 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/25">
            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-100">Acesso ao FinDesk</h2>
            <p class="text-xs text-slate-400 mt-1">Por favor, insira a senha para continuar</p>
        </div>
        <form wire:submit.prevent="login" class="space-y-4">
            <div>
                <input type="password" wire:model="passwordInput" placeholder="Senha"
                    class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 text-slate-100 text-center tracking-widest placeholder:tracking-normal text-sm"
                    required autofocus>
                @error('passwordInput') <span class="text-xs text-rose-500 mt-2 block">{{ $message }}</span> @enderror
            </div>
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold rounded-xl text-sm transition-all duration-200 active:scale-[0.98] shadow-lg shadow-indigo-500/10">
                Entrar
            </button>
        </form>
    </div>
</div>
