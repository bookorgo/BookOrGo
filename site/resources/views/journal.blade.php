@extends('layouts.app')
@section('title', 'UAE travel journal preview | BookOrGo')
@section('meta_description', 'Preview BookOrGo’s draft UAE travel-journal templates. No article is published or presented as verified advice.')
@section('content')
<section class="container page-intro journal-intro">
    <a class="breadcrumb" href="{{ route('home') }}">Home</a>
    <p class="eyebrow ink">Editorial template preview</p>
    <h1>The travel journal</h1>
    <p class="lead">A structured home for future original UAE guides. These sample outlines are drafts, not published travel advice.</p>
    <div class="sample-disclosure"><strong>Drafts only.</strong> Authors, dates, factual sources, imagery and publication approval are intentionally withheld until the editorial gates pass.</div>
</section>
<section class="container journal-list" aria-labelledby="draft-guides">
    <div class="results-toolbar">
        <div><p class="eyebrow ink">Journal hub</p><h2 id="draft-guides">{{ count($articles) }} draft guide templates</h2></div>
        <p>No live ads or affiliate links</p>
    </div>
    <div class="article-grid">
        @foreach($articles as $article)
            <article class="article-card">
                <div class="article-card-art motif-{{ $article['motif'] }}" aria-hidden="true"><span>Draft</span><i></i></div>
                <div class="article-card-copy">
                    <p class="card-kicker"><span>{{ $article['topic'] }}</span><span>{{ $article['status'] }}</span></p>
                    <h2><a href="{{ route('article', $article['slug']) }}">{{ $article['title'] }}</a></h2>
                    <p>{{ $article['summary'] }}</p>
                    <dl class="article-card-meta"><div><dt>Author</dt><dd>Not assigned</dd></div><div><dt>Publication</dt><dd>Not published</dd></div></dl>
                    <a class="detail-link" href="{{ route('article', $article['slug']) }}">Open article template <span aria-hidden="true">→</span></a>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection
