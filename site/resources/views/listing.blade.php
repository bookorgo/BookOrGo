@extends('layouts.app')
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
    <aside class="filters-column">
        <details class="listing-filters" open>
            <summary>Filters @if($activeCount)<span>{{ $activeCount }} active</span>@endif</summary>
            <form id="catalogue-filter-form" method="get" action="{{ $action }}" data-listing-form>
                <div class="filter-field">
                    <label for="catalogue-query">Search samples</label>
                    <input id="catalogue-query" name="q" type="search" maxlength="120" value="{{ $filters['q'] }}" placeholder="Try boat, city or visa">
                </div>
                @unless($fixedCategory)
                <div class="filter-field">
                    <label for="catalogue-category">Category</label>
                    <select id="catalogue-category" name="category">
                        <option value="">All categories</option>
                        @foreach($categories as $slug => $entry)<option value="{{ $slug }}" @selected($filters['category'] === $slug)>{{ $entry['name'] }}</option>@endforeach
                    </select>
                </div>
                @endunless
                <div class="filter-field">
                    <label for="catalogue-area">Area</label>
                    <select id="catalogue-area" name="area">
                        <option value="">All sample areas</option>
                        @foreach($areas as $area)<option value="{{ $area }}" @selected($filters['area'] === $area)>{{ $area }}</option>@endforeach
                    </select>
                </div>
                <div class="filter-field">
                    <label for="catalogue-duration">Duration</label>
                    <select id="catalogue-duration" name="duration">
                        <option value="">Any sample duration</option>
                        @foreach($durations as $value => $label)<option value="{{ $value }}" @selected($filters['duration'] === $value)>{{ $label }}</option>@endforeach
                    </select>
                </div>
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
    </aside>

    <div class="results-column" id="catalogue-results" aria-live="polite">
        <div class="results-toolbar">
            <div><p class="eyebrow ink">Sample results</p><h2 id="results-heading">{{ $total }} {{ $total === 1 ? 'fictional card' : 'fictional cards' }}</h2></div>
            <div class="result-sort"><label for="catalogue-sort">Sort by</label><select id="catalogue-sort" name="sort" form="catalogue-filter-form"><option value="recommended" @selected($filters['sort'] === 'recommended')>Curated sample order</option><option value="title-asc" @selected($filters['sort'] === 'title-asc')>Title A–Z</option><option value="title-desc" @selected($filters['sort'] === 'title-desc')>Title Z–A</option></select><button type="submit" form="catalogue-filter-form">Apply sort</button><p>Page {{ $page }} of {{ $lastPage }}</p></div>
        </div>
        <p class="loading-status" data-loading-status hidden>Updating sample results…</p>

        @if(count($items))
            <div class="experience-list">
                @foreach($items as $item)<x-experience-card :item="$item" :categories="$categories" :durations="$durations" />@endforeach
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
