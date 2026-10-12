@extends('layouts.app')
@section('content')
<section class="hero">
    <div class="hero-art" aria-hidden="true"><span class="hero-sun"></span><span class="skyline tower-one"></span><span class="skyline tower-two"></span><span class="skyline tower-three"></span><span class="dune dune-back"></span><span class="dune dune-front"></span></div>
    <div class="container hero-content">
        <p class="eyebrow"><span aria-hidden="true">✦</span> One destination. So many possibilities.</p>
        <h1>Your next UAE<br>experience <em>starts here.</em></h1>
        <p class="hero-description">From city days to time on the water.<br>Find the category that speaks to you.</p>
        <x-search-form />
        <p class="search-help">Browse our categories while the BookOrGo catalogue takes shape.</p>
    </div>
</section>
<section class="container section" aria-labelledby="explore-heading">
    <div class="section-heading"><div><p class="eyebrow ink">A little inspiration</p><h2 id="explore-heading">Where will curiosity take you?</h2></div><p>Six ways to start exploring.<br>All with the UAE in mind.</p></div>
    <div class="category-grid">@foreach($categories as $slug => $category)<x-category-card :slug="$slug" :category="$category" />@endforeach</div>
</section>
<section class="container journal-banner" aria-labelledby="journal-heading"><div><p class="eyebrow ink">The travel journal</p><h2 id="journal-heading">Good trips start with a little inspiration.</h2><p>Our editorial space is taking shape. No guides have been published yet.</p><a class="button navy" href="{{ route('journal') }}">Explore the journal <span aria-hidden="true">→</span></a></div><div class="journal-art" aria-hidden="true"><span>UAE</span><i></i></div></section>
<section class="container preview-explainer"><span class="info-mark" aria-hidden="true">i</span><div><h2>A note on this first look</h2><p>You’re exploring the first part of the new BookOrGo. Category pages are ready to browse; verified listings and booking features will follow. Nothing here is an offer, a visa approval or a confirmation of availability.</p></div></section>
@endsection
