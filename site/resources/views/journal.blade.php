@extends('layouts.app')
@section('title', 'UAE travel journal | BookOrGo')
@section('content')
<section class="container page-intro"><a class="breadcrumb" href="{{ route('home') }}">Home</a><p class="eyebrow ink">Ideas for another day</p><h1>The travel journal</h1><p class="lead">A future home for thoughtful UAE travel stories.</p></section>
<section class="container empty-panel"><span class="empty-symbol" aria-hidden="true">✦</span><h2>The first chapter is still to come</h2><p>No articles have been published yet. For now, explore the categories that will shape BookOrGo.</p><a class="button navy" href="{{ route('home') }}">Back to discovery <span aria-hidden="true">→</span></a></section>
@endsection
