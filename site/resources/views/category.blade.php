@extends('layouts.app')
@section('title', $category['name'].' in the UAE | BookOrGo')
@section('content')
<section class="page-intro container"><a class="breadcrumb" href="{{ route('home') }}">Home</a><span aria-hidden="true"> / </span><span>{{ $category['name'] }}</span><p class="eyebrow ink">{{ $category['eyebrow'] }}</p><h1>{{ $category['name'] }} in the UAE</h1><p class="lead">{{ $category['description'] }}</p></section>
<section class="container empty-panel" aria-labelledby="empty-heading"><span class="empty-symbol" aria-hidden="true">✦</span><h2 id="empty-heading">This collection is taking shape</h2><p>No verified {{ strtolower($category['name']) }} listings are published yet. Prices, availability and booking options will appear only when ready.</p>@if($slug === 'visas')<p>Visa rules and eligibility are not provided in this preview. No application or approval service is currently offered.</p>@endif<a class="button navy" href="{{ route('home') }}">Explore other categories <span aria-hidden="true">→</span></a></section>
@endsection
