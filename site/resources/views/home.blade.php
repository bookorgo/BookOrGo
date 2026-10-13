@extends('layouts.app')
@section('content')
<section class="hero">
    <div class="hero-art" aria-hidden="true"><x-scene motif="arch" /><span class="hero-art-label">Original UAE-inspired illustration</span></div>
    <div class="container hero-content">
        <p class="eyebrow"><span aria-hidden="true">✦</span> Explore more. Experience more.</p>
        <h1>Your next UAE<br>experience <em>starts here.</em></h1>
        <p class="hero-description">City days, desert horizons and time on the water.<br>Find your next idea across Dubai and the UAE.</p>
        <x-search-form />
        <p class="search-help">Browse our categories while the BookOrGo catalogue takes shape.</p>
    </div>
</section>
<section class="container section" aria-labelledby="destinations-heading">
    <div class="section-heading"><div><p class="eyebrow ink">Plan your next adventure</p><h2 id="destinations-heading">Where do you want to go?</h2><p class="section-subtitle">Explore our UAE sample catalogue by area.</p></div><a class="section-link" href="{{ route('search') }}">Explore all samples <span aria-hidden="true">→</span></a></div>
    <div class="destination-grid">@foreach($destinations as $destination)
        <a class="destination-card" href="{{ route('search', ['area' => $destination['name']]) }}"><x-scene :motif="$destination['motif']" /><span class="destination-copy"><strong>{{ $destination['name'] }}</strong><small>Explore sample layouts</small></span><span class="round-arrow" aria-hidden="true">↗</span></a>
    @endforeach</div>
    <div class="discovery-trust"><div><span aria-hidden="true">✦</span><p><strong>Six ways to explore</strong><small>One consistent discovery experience</small></p></div><div><span aria-hidden="true">◇</span><p><strong>Clear sample status</strong><small>No invented prices or reviews</small></p></div><div><span aria-hidden="true">✓</span><p><strong>Know before you go</strong><small>Verified information comes before offers</small></p></div></div>
</section>
<section class="container section featured-section" aria-labelledby="featured-heading">
    <div class="section-heading"><div><p class="eyebrow ink">A first look at the catalogue</p><h2 id="featured-heading">Ideas worth exploring</h2><p class="section-subtitle">Fictional samples for design review, not bookable experiences.</p></div><a class="section-link" href="{{ route('search') }}">View all sample layouts <span aria-hidden="true">→</span></a></div>
    <div class="featured-grid">@foreach($featured as $item)
        <article class="featured-card"><div class="featured-art"><x-scene :motif="$item['motif']" /><span class="sample-ribbon">Fictional sample</span></div><div class="featured-copy"><p class="card-kicker">{{ $item['area'] }} · {{ $categories[$item['category']]['name'] }}</p><h3><a href="{{ route('experience.detail', ['category' => $item['category'], 'location' => $item['location_slug'], 'experience' => $item['id']]) }}">{{ $item['title'] }}</a></h3><p class="featured-duration">{{ $durations[$item['duration']] }} · Sample attribute</p><div class="featured-bottom"><strong>No live offer or price</strong><a href="{{ route('experience.detail', ['category' => $item['category'], 'location' => $item['location_slug'], 'experience' => $item['id']]) }}" aria-label="View {{ $item['title'] }}">View detail <span aria-hidden="true">→</span></a></div></div></article>
    @endforeach</div>
</section>
<section class="container section" aria-labelledby="explore-heading">
    <div class="section-heading"><div><p class="eyebrow ink">So many ways to explore</p><h2 id="explore-heading">What would you like to discover?</h2><p class="section-subtitle">Six categories. One UAE-first starting point.</p></div></div>
    <div class="category-grid">@foreach($categories as $slug => $category)<x-category-card :slug="$slug" :category="$category" />@endforeach</div>
</section>
<section class="container discovery-callout"><div><p class="eyebrow">Make room for a new idea</p><h2>Something special starts with curiosity.</h2><p>Browse the layouts. See how your next UAE adventure could take shape.</p><a class="button" href="{{ route('search') }}">Explore samples <span aria-hidden="true">→</span></a></div><span class="callout-orbit" aria-hidden="true">↗</span></section>
<section class="container section" aria-labelledby="journal-heading"><div class="section-heading"><div><p class="eyebrow ink">The travel journal</p><h2 id="journal-heading">A little inspiration for your next trip</h2><p class="section-subtitle">Draft guide templates. Factual sources and publication approval are pending.</p></div><a class="section-link" href="{{ route('journal') }}">Explore the journal <span aria-hidden="true">→</span></a></div><div class="home-guide-grid">@foreach($articles as $article)<article class="home-guide"><div class="home-guide-art"><x-scene :motif="$loop->index === 0 ? 'arch' : ($loop->index === 1 ? 'sun' : 'spark')" /><span class="sample-ribbon">Draft template</span></div><div><p class="card-kicker">Not published · Sources pending</p><h3><a href="{{ route('article', $article['slug']) }}">{{ $article['title'] }}</a></h3><a class="section-link" href="{{ route('article', $article['slug']) }}">View draft <span aria-hidden="true">→</span></a></div></article>@endforeach</div></section>
<section class="newsletter-preview"><div class="container"><div><span aria-hidden="true">✉</span><div><h2>A little travel inspiration</h2><p>Newsletter preview only. Subscriptions are not open.</p></div></div><div class="newsletter-controls"><label class="sr-only" for="newsletter-preview">Email preview — disabled</label><input id="newsletter-preview" type="email" placeholder="Email subscriptions coming later" disabled><button type="button" disabled>Not active yet</button></div></div></section>
<section class="container preview-explainer"><span class="info-mark" aria-hidden="true">i</span><div><h2>A note on this first look</h2><p>You’re exploring the first part of the new BookOrGo. Category pages are ready to browse; verified listings and booking features will follow. Nothing here is an offer, a visa approval or a confirmation of availability.</p></div></section>
@endsection
