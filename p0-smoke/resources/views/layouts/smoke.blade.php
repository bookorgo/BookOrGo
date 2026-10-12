<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="robots" content="noindex,nofollow">
    <link rel="canonical" href="{{ url($canonical) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-950 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-4">
            <a class="text-xl font-black tracking-tight text-blue-700" href="{{ route('p0.home') }}">BookOrGo</a>
            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-900">Protected sample · not live</span>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="mt-16 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-5 py-8 text-sm text-slate-600">
            P0 validation content only. No prices, availability, bookings or partner approvals are represented.
        </div>
    </footer>
</body>
</html>
