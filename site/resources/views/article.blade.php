@extends('layouts.app')
@section('title', $article['title'].' | BookOrGo draft')
@section('meta_description', $article['summary'])
@section('social_meta')
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $article['title'] }}">
    <meta property="og:description" content="{{ $article['summary'] }}">
    <meta property="og:url" content="{{ route('article', $article['slug']) }}">
@endsection
@section('content')
<nav class="container detail-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span>
    <a href="{{ route('journal') }}">Travel journal</a><span aria-hidden="true">/</span>
    <span>{{ $article['topic'] }}</span>
</nav>
<article class="article-page">
    <header class="container article-hero">
        <div class="article-heading">
            <p class="eyebrow ink">{{ $article['status'] }}</p>
            <h1>{{ $article['title'] }}</h1>
            <p class="lead">{{ $article['summary'] }}</p>
            <dl class="article-byline">
                <div><dt>Author</dt><dd>Not assigned in this preview</dd></div>
                <div><dt>Published</dt><dd>Not published</dd></div>
                <div><dt>Updated</dt><dd>Not reviewed</dd></div>
            </dl>
        </div>
        <div class="article-cover motif-{{ $article['motif'] }}" role="img" aria-label="Original abstract placeholder artwork for this draft article">
            <span>Original placeholder artwork</span><i></i>
        </div>
    </header>
    <div class="container article-shell">
        <div class="article-aside">
            <nav class="article-toc" aria-label="On this page">
                <p class="eyebrow ink">On this page</p>
                <ol>@foreach($article['sections'] as $section)<li><a href="#{{ $section['id'] }}">{{ $section['title'] }}</a></li>@endforeach<li><a href="#sources">Source status</a></li></ol>
            </nav>
            <div class="inactive-ad" role="group" aria-label="Inactive advertising preview"><strong>Advertising area</strong><span>Inactive preview — no ad loaded</span></div>
        </div>
        <div class="article-body">
            <section class="article-summary">
                <p class="eyebrow ink">At a glance</p>
                <h2>What this template is designed to answer</h2>
                <p>The final guide should help a traveller make a clear decision using original writing and verified current evidence. This preview demonstrates structure only.</p>
            </section>
            @foreach($article['sections'] as $section)
                <section id="{{ $section['id'] }}" class="article-section">
                    <h2>{{ $section['title'] }}</h2>
                    <p>{{ $section['body'] }}</p>
                </section>
            @endforeach
            <section id="sources" class="article-sources">
                <p class="eyebrow ink">Source register</p>
                <h2>No factual sources attached</h2>
                <p>This draft is not eligible for publication. A named editor must add evidence for every changing fact, record author/reviewer identity and dates, confirm media rights, and approve the final copy.</p>
            </section>
            <section class="article-disclosure">
                <h2>Commercial disclosure</h2>
                <p>No advertisement or affiliate link is active in this template preview. Future placements must stay visibly separate from navigation and editorial content.</p>
            </section>
        </div>
    </div>
</article>
<section class="related-section" aria-labelledby="related-drafts">
    <div class="container">
        <div class="section-heading"><div><p class="eyebrow ink">Related sample layouts</p><h2 id="related-drafts">Explore linked category examples</h2></div><p>Fictional records only</p></div>
        <div class="related-grid">
            @foreach($related as $item)
                <article><p>{{ $item['area'] }} · Sample layout</p><h3><a href="{{ route('experience.detail', [$item['category'], $item['location_slug'], $item['id']]) }}">{{ $item['title'] }}</a></h3><span>No live offer or price</span></article>
            @endforeach
        </div>
    </div>
</section>
@endsection
