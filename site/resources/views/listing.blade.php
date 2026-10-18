@extends('layouts.app')
@section('page_class', 'page-listing')
@section('title', ($fixedCategory ? $category['name'].' sample catalogue' : 'Explore UAE sample listings').' | BookOrGo')
@section('meta_description', 'Browse BookOrGo’s clearly labelled fictional UAE catalogue samples. No prices, availability, offers or bookings are live.')
@section('content')
@php
    $cleanQuery = array_filter($filters, fn ($value) => $value !== '');
    $activeCount = collect($filters)->except(['sort'])->filter(fn ($value) => $value !== '')->count();
@endphp
<section class="container page-intro listing-intro">
    <div class="listing-search"><x-search-form :value="$filters['q']" /></div>
    <a class="breadcrumb" href="{{ route('home') }}">Home</a>
    @if($fixedCategory)<span aria-hidden="true"> / </span><span>{{ $category['name'] }}</span>@endif
    <p class="eyebrow ink">{{ $fixedCategory ? $category['eyebrow'] : 'A transparent first catalogue' }}</p>
    <h1>{{ $fixedCategory ? $category['name'].' sample catalogue' : 'Explore UAE sample listings' }}</h1>
    <p class="lead">{{ $fixedCategory ? $category['description'] : 'Use category, area, duration and family filters to explore this frontend demonstration.' }}</p>
    <div class="sample-disclosure" role="note"><strong>Demonstration data only.</strong> Every card below is fictional and exists to test the layout. Nothing is an offer, price, availability statement, recommendation or booking option.</div>
</section>

<section class="container listing-shell" aria-labelledby="results-heading">
    <div class="filters-column" role="region" aria-label="Catalogue filters">
        <details class="listing-filters">
            <summary>Filters @if($activeCount)<span>{{ $activeCount }} active</span>@endif</summary>
            <form id="catalogue-filter-form" method="get" action="{{ $action }}" data-listing-form>
                <input type="hidden" name="sort" value="{{ $filters['sort'] }}"><div class="filter-field">
                    <label for="catalogue-query">Search samples</label>
                    <input id="catalogue-query" name="q" type="search" maxlength="120" value="{{ $filters['q'] }}" placeholder="Try boat, city or visa">
                </div>
<fieldset class="filter-choices"><legend>Location <small>Choose one</small></legend><label><input type="radio" name="area" value="" @checked($filters['area']==='')> All sample areas</label>@foreach($areas as $area)<label><input type="radio" name="area" value="{{ $area }}" @checked($filters['area']===$area)> {{ $area }}</label>@endforeach</fieldset>
@unless($fixedCategory)<fieldset class="filter-choices"><legend>Category <small>Choose one</small></legend><label><input type="radio" name="category" value="" @checked($filters['category']==='')> All categories</label>@foreach($categories as $slug=>$entry)<label><input type="radio" name="category" value="{{ $slug }}" @checked($filters['category']===$slug)> {{ $entry['name'] }}</label>@endforeach</fieldset>@endunless
<fieldset class="filter-choices"><legend>Duration <small>Choose one</small></legend><label><input type="radio" name="duration" value="" @checked($filters['duration']==='')> Any sample duration</label>@foreach($durations as $value=>$label)<label><input type="radio" name="duration" value="{{ $value }}" @checked($filters['duration']===$value)> {{ $label }}</label>@endforeach</fieldset>
                <fieldset class="filter-field radio-group">
                    <legend>Family suitability</legend>
                    <label><input type="radio" name="family" value="" @checked($filters['family'] === '')> Any</label>
                    <label><input type="radio" name="family" value="yes" @checked($filters['family'] === 'yes')> Sample yes</label>
                    <label><input type="radio" name="family" value="no" @checked($filters['family'] === 'no')> Sample no</label>
                </fieldset>
                <button class="button filter-button" type="submit">Apply filters <span aria-hidden="true">→</span></button>
                <a class="reset-link" href="{{ $action }}">Reset all filters</a>
            </form>
        </details>
    </div>

    <div class="results-column" id="catalogue-results" aria-live="polite">
        <div class="results-toolbar">
            <div><p class="eyebrow ink">Sample results</p><h2 id="results-heading">{{ $total }} {{ $total === 1 ? 'fictional card' : 'fictional cards' }}</h2></div>
<p class="result-page-count">Page {{ $page }} of {{ $lastPage }}</p>
        </div>
        <nav class="sort-tabs" aria-label="Sample sorting">
            @foreach(['recommended' => 'Our sample order', 'title-asc' => 'Title A–Z', 'title-desc' => 'Title Z–A'] as $sort => $label)
                <a href="{{ $action.'?'.http_build_query(array_merge($cleanQuery, ['sort' => $sort, 'page' => 1])) }}" @if($filters['sort'] === $sort) aria-current="true" @endif>{{ $label }}</a>
            @endforeach
        </nav>
        <p class="loading-status" data-loading-status hidden>Updating sample results…</p>

        @if(count($items))
            <div class="experience-list">
                @foreach($items as $item)
                    <x-experience-card :item="$item" :categories="$categories" :durations="$durations" :eager="$loop->first" />
                    @if($loop->iteration === 5 && count($items) >= 6)
                    <section class="listing-inspiration" aria-label="More sample inspiration"><h2>More sample inspiration</h2><p>Fictional layouts · no offers or discounts</p><div class="inspiration-grid">
                        @foreach(array_slice($items, 0, 3) as $inspiration)
                        <a class="inspiration-card" href="{{ route('experience.detail', ['category'=>$inspiration['category'], 'location'=>$inspiration['location_slug'], 'experience'=>$inspiration['id']]) }}"><x-photo image-slot="listing" :motif="$inspiration['motif']" /><span><small>Fictional sample</small><strong>{{ $inspiration['title'] }}</strong><small>View layout →</small></span></a>
                        @endforeach
                    </div></section>
                    @endif
                @endforeach
            </div>
        @else
            <div class="empty-panel listing-empty">
                <span class="empty-symbol" aria-hidden="true">⌕</span>
                <h2>No sample cards match</h2>
                <p>Adjust the demonstration filters or reset them. No product will be invented to fill an empty result.</p>
                <a class="button navy" href="{{ $action }}">Reset sample filters <span aria-hidden="true">→</span></a>
            </div>
        @endif

        @if($lastPage > 1)
        <nav class="pagination" aria-label="Sample result pages">
            @for($number = 1; $number <= $lastPage; $number++)
                @php($pageUrl = $action.'?'.http_build_query(array_merge($cleanQuery, ['page' => $number])))
                @if($number === $page)
                    <span aria-current="page">{{ $number }}</span>
                @else
                    <a href="{{ $pageUrl }}" aria-label="Page {{ $number }}">{{ $number }}</a>
                @endif
            @endfor
        </nav>
        @endif
    </div>
</section>
@endsection
