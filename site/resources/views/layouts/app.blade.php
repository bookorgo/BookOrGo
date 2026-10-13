<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Discover Dubai & the UAE | BookOrGo')</title>
    <meta name="description" content="@yield('meta_description', 'Explore BookOrGo’s UAE discovery categories. This development preview has no bookable offers or live availability.')">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#082b4c">
    <link rel="canonical" href="{{ rtrim(config('app.url'), '/') . (request()->is('/') ? '/' : '/'.request()->path()) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="site-header">
        <div class="container header-top">
            <a class="wordmark" href="{{ route('home') }}" aria-label="BookOrGo home">Book<span>Or</span>Go<span class="brand-dot">.</span></a>
            <p class="header-context">A new way to explore the UAE</p>
            <a class="journal-link" href="{{ route('journal') }}">Travel journal <span aria-hidden="true">↗</span></a>
            <details class="mobile-menu">
                <summary>Menu <span aria-hidden="true">☰</span></summary>
                <nav aria-label="Mobile navigation">
                    @foreach($categories as $key => $item)
                        <a href="{{ route('category', $key) }}" @if(request()->is($key, $key.'/*')) aria-current="page" @endif>{{ $item['name'] }}</a>
                    @endforeach
                    <a href="{{ route('journal') }}">Travel journal</a>
                </nav>
            </details>
        </div>
        <nav class="container desktop-nav" aria-label="Main navigation">
            @foreach($categories as $key => $item)
                <a href="{{ route('category', $key) }}" @if(request()->is($key, $key.'/*')) aria-current="page" @endif>{{ $item['name'] }}</a>
            @endforeach
            <span class="region">Dubai & the UAE</span>
        </nav>
    </header>
    <div class="preview-notice"><div class="container"><span class="status-dot" aria-hidden="true"></span><strong>Development preview</strong><span>We’re preparing the catalogue. No live offers or bookings yet.</span></div></div>
    <main id="main" tabindex="-1">@yield('content')</main>
    <footer class="site-footer">
        <div class="container footer-grid">
            <div><a class="wordmark" href="{{ route('home') }}">Book<span>Or</span>Go<span class="brand-dot">.</span></a><p>Room for your next UAE adventure.</p><p class="muted">A fresh start. Thoughtfully built, one step at a time.</p></div>
            <nav aria-label="Explore categories"><h2>Explore</h2>@foreach($categories as $key => $item)<a href="{{ route('category', $key) }}">{{ $item['name'] }}</a>@endforeach</nav>
            <div><h2>About this preview</h2><p>Category discovery is available. Products, prices, availability and booking services are not published.</p><a class="text-link light" href="{{ route('journal') }}">Visit the travel journal <span aria-hidden="true">→</span></a></div>
        </div>
        <div class="container footer-bottom"><span>© {{ date('Y') }} BookOrGo</span><span>Dubai & the United Arab Emirates</span></div>
    </footer>
</body>
</html>
