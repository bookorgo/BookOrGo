@extends('layouts.app')
@section('title', $page['title'].' | BookOrGo')
@section('content')
<section class="container information-page">
    <a class="breadcrumb" href="{{ route('home') }}">Home</a>
    <p class="eyebrow ink">Development preview</p>
    <h1>{{ $page['heading'] }}</h1>
    <p class="lead">{{ $page['body'] }}</p>
    <div class="sample-disclosure" role="note"><strong>Draft information.</strong> These details are not a reviewed legal or commercial release.</div>
    <a class="button navy" href="{{ route('home') }}">Back to discovery <span aria-hidden="true">→</span></a>
</section>
@endsection
