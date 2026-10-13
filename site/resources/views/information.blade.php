@extends('layouts.app')
@section('title', $page['title'].' | BookOrGo')
@section('content')
<section class="container information-page">
    <a class="breadcrumb" href="{{ route('home') }}">Home</a>
    <p class="eyebrow ink">Development preview</p>
    <h1>{{ $page['heading'] }}</h1>
    <p class="lead">{{ $page['body'] }}</p>
    @if(request()->is('photo-credits'))
        <p><a class="text-link" href="https://unsplash.com/license" rel="nofollow noreferrer">Unsplash License</a></p>
        <ul class="photo-credits">@foreach(config('photo-credits') as $credit)<li>{{ $credit['caption'] }} — <a href="{{ $credit['url'] }}" rel="nofollow noreferrer">{{ $credit['author'] }} / Unsplash</a></li>@endforeach</ul>
        <p>Inter font © The Inter Project Authors, distributed under the SIL Open Font License 1.1.</p>
    @endif
    <div class="sample-disclosure" role="note"><strong>Draft information.</strong> These details are not a reviewed legal or commercial release.</div>
    <a class="button navy" href="{{ route('home') }}">Back to discovery <span aria-hidden="true">→</span></a>
</section>
@endsection
