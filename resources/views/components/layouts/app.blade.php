<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'FinDesk - Gerenciador Financeiro' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    
    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Disable F12 Developer Tools -->
    <script>
        window.addEventListener('keydown', (e) => {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i' || e.key === 'C' || e.key === 'c' || e.key === 'J' || e.key === 'j')) || (e.ctrlKey && (e.key === 'U' || e.key === 'u'))) {
                e.preventDefault();
                return false;
            }
        });
        window.addEventListener('contextmenu', (e) => {
            e.preventDefault();
        });
    </script>
</head>
<body class="h-full font-sans antialiased overflow-hidden selection:bg-indigo-500 selection:text-white">
    <div class="flex h-full w-full overflow-hidden bg-slate-950">
        <!-- Main Content Wrapper -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto relative z-0 focus:outline-none">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
