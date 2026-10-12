@extends('layouts.app')
@section('title', 'Explore categories | BookOrGo')
@section('content')
<section class="container page-intro"><a class="breadcrumb" href="{{ route('home') }}">Home</a><p class="eyebrow ink">Find your starting point</p><h1>Explore our categories</h1><p class="lead">This search covers categories, not live products or availability.</p><x-search-form :value="$query" /></section>
<section class="container section search-results" aria-labelledby="results-heading"><h2 id="results-heading">{{ $query === '' ? 'All categories' : 'Category matches for “'.$query.'”' }}</h2>@if(count($results))<div class="category-grid">@foreach($results as $slug => $category)<x-category-card :slug="$slug" :category="$category" />@endforeach</div>@else<div class="empty-panel"><h3>No matching categories yet</h3><p>Try a shorter search, such as “activities”, “boat” or “events”.</p><a class="text-link" href="{{ route('search') }}">Browse all six categories →</a></div>@endif</section>
@endsection
