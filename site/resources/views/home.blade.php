@extends('layouts.app')
@section('page_class', 'page-home')
@section('content')
<section class="hero">
    <div class="hero-art" aria-hidden="true"><div class="hero-portrait"><x-photo motif="arch" :eager="true" /></div><span class="hero-art-label"><b>✦ &nbsp; Made for memories</b><small>UAE destination inspiration</small></span></div>
    <div class="container hero-content">
        <p class="eyebrow"><span aria-hidden="true">✦</span> Explore more. Experience more.</p>
        <h1>Your next great<br><em>experience</em> starts here.</h1>
        <p class="hero-description">City days, desert horizons and time on the water.<br>Find your next idea across Dubai and the UAE.</p>
        <p class="hero-promises">✓ UAE-first discovery &nbsp;&nbsp;&nbsp; ✓ Clearly labelled samples</p>
        <x-search-form />
        <p class="search-help">Development preview · Fictional samples, no live offers or bookings.</p>
    </div>
</section>
<section class="container section" aria-labelledby="destinations-heading">
    <div class="section-heading"><div><p class="eyebrow ink">Plan your next adventure</p><h2 id="destinations-heading">Where do you want to go?</h2><p class="section-subtitle">Explore our UAE sample catalogue by area.</p></div><a class="section-link" href="{{ route('search') }}">Explore all samples <span aria-hidden="true">→</span></a></div>
    <div class="destination-grid">@foreach($destinations as $destination)
        <a class="destination-card" href="{{ route('search', ['area' => $destination['name']]) }}"><x-photo :name="['Dubai'=>'dubai','Dubai Marina'=>'marina','Abu Dhabi'=>'abu-dhabi','Ras Al Khaimah'=>'mountains','Fujairah'=>'fujairah','Sharjah'=>'sharjah'][$destination['name']]" /><span class="destination-copy"><strong>{{ $destination['name'] }}</strong><small>Explore sample layouts</small></span><span class="round-arrow" aria-hidden="true">↗</span></a>
    @endforeach</div>
    <div class="discovery-trust"><div><span aria-hidden="true">✦</span><p><strong>Six ways to explore</strong><small>One consistent discovery experience</small></p></div><div><span aria-hidden="true">◇</span><p><strong>Clear sample status</strong><small>No invented prices or reviews</small></p></div><div><span aria-hidden="true">✓</span><p><strong>Know before you go</strong><small>Verified information comes before offers</small></p></div></div>
</section>
<section class="container section featured-section" aria-labelledby="featured-heading">
    <div class="section-heading"><div><p class="eyebrow ink">A first look at the catalogue</p><h2 id="featured-heading">Ideas worth exploring</h2><p class="section-subtitle">Fictional samples for design review, not bookable experiences.</p></div><a class="section-link" href="{{ route('search') }}">View all sample layouts <span aria-hidden="true">→</span></a></div>
    <div class="featured-grid">@foreach($featured as $item)
        <article class="featured-card"><div class="featured-art"><x-photo :motif="$item['motif']" /><span class="sample-ribbon">Fictional sample</span></div><div class="featured-copy"><p class="card-kicker">{{ $item['area'] }} · {{ $categories[$item['category']]['name'] }}</p><h3><a href="{{ route('experience.detail', ['category' => $item['category'], 'location' => $item['location_slug'], 'experience' => $item['id']]) }}">{{ $item['title'] }}</a></h3><p class="featured-duration">{{ $durations[$item['duration']] }} · Sample attribute</p><div class="featured-bottom"><strong>No live offer or price</strong><a href="{{ route('experience.detail', ['category' => $item['category'], 'location' => $item['location_slug'], 'experience' => $item['id']]) }}" aria-label="View {{ $item['title'] }}">View detail <span aria-hidden="true">→</span></a></div></div></article>
    @endforeach</div>
</section>
<section class="container section" aria-labelledby="explore-heading">
    <div class="section-heading"><div><p class="eyebrow ink">So many ways to explore</p><h2 id="explore-heading">What would you like to discover?</h2><p class="section-subtitle">Six categories. One UAE-first starting point.</p></div></div>
    <div class="category-grid">@foreach($categories as $slug => $category)<x-category-card :slug="$slug" :category="$category" />@endforeach</div>
</section>
<section class="container discovery-callout"><div><p class="eyebrow">Make room for a new idea</p><h2>Something special starts with curiosity.</h2><p>Browse the layouts. See how your next UAE adventure could take shape.</p><a class="button" href="{{ route('search') }}">Explore samples <span aria-hidden="true">→</span></a></div><span class="callout-orbit" aria-hidden="true">↗</span></section>
<section class="container section region-explorer" aria-labelledby="region-heading">
<div class="section-heading"><div><p class="eyebrow ink">Explore the UAE</p><h2 id="region-heading">More places, more possibilities</h2><p class="section-subtitle">Choose an area and explore the sample catalogue.</p></div></div>
<nav class="region-pills" aria-label="Explore UAE areas"><a href="{{ route('search') }}" aria-current="true">UAE</a>@foreach($destinations as $destination)<a href="{{ route('search', ['area'=>$destination['name']]) }}">{{ $destination['name'] }}</a>@endforeach</nav>
<div class="region-grid">@foreach($destinations as $destination)<a class="region-card" href="{{ route('search', ['area'=>$destination['name']]) }}"><x-photo :name="['Dubai'=>'dubai','Dubai Marina'=>'marina','Abu Dhabi'=>'abu-dhabi','Ras Al Khaimah'=>'mountains','Fujairah'=>'fujairah','Sharjah'=>'sharjah'][$destination['name']]" /><span><strong>{{ $destination['name'] }}</strong><small>Explore sample experiences</small></span></a>@endforeach
<a class="region-card" href="{{ route('search', ['q'=>'desert']) }}"><x-photo name="desert" /><span><strong>Desert escapes</strong><small>Explore sample experiences</small></span></a>
<a class="region-card" href="{{ route('search', ['q'=>'boat']) }}"><x-photo name="marina" /><span><strong>On the water</strong><small>Explore sample experiences</small></span></a>
</div><a class="more-destinations" href="{{ route('search') }}">Show more sample experiences →</a></section>
<section class="newsletter-preview"><div class="container"><div><span aria-hidden="true">✉</span><div><h2>A little travel inspiration</h2><p>Newsletter preview only. Subscriptions are not open.</p></div></div><div class="newsletter-controls"><label class="sr-only" for="newsletter-preview">Email preview — disabled</label><input id="newsletter-preview" type="email" placeholder="Email subscriptions coming later" disabled><button type="button" disabled>Not active yet</button></div></div></section>

@endsection
