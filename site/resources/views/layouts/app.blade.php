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
    @yield('social_meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="@yield('page_class', 'page-standard')">
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="site-header">
        <div class="container header-top">
            <a class="wordmark" href="{{ route('home') }}" aria-label="BookOrGo home">bookorgo<span class="brand-dot">.</span></a>
            <nav class="header-utilities" aria-label="Information"><span>UAE</span><span>◎ &nbsp; EN</span><a href="{{ route('information', 'contact') }}">ⓘ &nbsp; Help</a><a class="utility-button" href="{{ route('information', 'about') }}">About us</a><a class="utility-button" href="{{ route('journal') }}">Journal</a></nav>
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
                <a href="{{ route('category', $key) }}" @if(request()->is($key, $key.'/*')) aria-current="page" @endif><span class="nav-icon" aria-hidden="true">{{ ['activities'=>'✥','holidays'=>'▤','visas'=>'▣','cruises'=>'♧','yachts'=>'⛵','events'=>'◆'][$key] }}</span>{{ $item['name'] }}</a>
            @endforeach
            <span class="region">Dubai & the UAE</span>
        </nav>
    </header>
    <main id="main" tabindex="-1">@yield('content')</main>
    <div class="preview-notice"><div class="container"><span class="status-dot" aria-hidden="true"></span><strong>Development preview</strong><span>Labelled fictional samples and illustrations. No live offers or bookings.</span></div></div>
    <footer class="site-footer">
        <div class="container footer-grid">
            <div><a class="wordmark" href="{{ route('home') }}">bookorgo<span class="brand-dot">.</span></a><p>Room for your next UAE adventure.</p><p class="muted">Discover more and go further.</p></div>
            <nav aria-label="Explore categories"><h2>Explore</h2>@foreach($categories as $key => $item)<a href="{{ route('category', $key) }}">{{ $item['name'] }}</a>@endforeach</nav>
            <nav aria-label="Information and policies"><h2>BookOrGo</h2><a href="{{ route('information', 'about') }}">About</a><a href="{{ route('information', 'contact') }}">Contact</a><a href="{{ route('information', 'disclosure') }}">Affiliate disclosure</a><a href="{{ route('information', 'privacy') }}">Privacy draft</a><a href="{{ route('information', 'terms') }}">Terms draft</a><a href="{{ route('journal') }}">Travel journal</a><p>No live offers. Future checkout is with an external partner.</p></nav>
        </div>
        <div class="container footer-bottom"><span>© {{ date('Y') }} BookOrGo</span><span>Dubai & the United Arab Emirates</span></div>
    </footer>
</body>
</html>
