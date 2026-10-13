@extends('layouts.app')
@section('title', 'Filter could not be applied | BookOrGo')
@section('meta_description', 'A BookOrGo sample catalogue filter could not be applied.')
@section('content')
<section class="container page-intro"><a class="breadcrumb" href="{{ route('home') }}">Home</a><p class="eyebrow ink">Safe filter state</p><h1>We couldn’t apply those filters</h1><p class="lead">{{ $message }}</p></section>
<section class="container empty-panel" role="alert"><span class="empty-symbol" aria-hidden="true">!</span><h2>Start from a clean sample view</h2><p>No search or catalogue content was changed. Reset the filters and try again.</p><a class="button navy" href="{{ $resetUrl }}">Reset filters <span aria-hidden="true">→</span></a></section>
@endsection
