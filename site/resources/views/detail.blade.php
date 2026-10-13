@extends('layouts.app')
@section('title', $item['title'].' | '.$category['name'].' | BookOrGo')
@section('meta_description', 'A clearly labelled fictional BookOrGo detail-page sample. No live offer, price, availability, advice or booking is provided.')
@section('content')
<section class="container detail-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span>
    <a href="{{ route('category', $item['category']) }}">{{ $category['name'] }}</a><span aria-hidden="true">/</span>
    <span>{{ $item['title'] }}</span>
</section>

<section class="container detail-hero">
    <div class="detail-art card-{{ $item['motif'] }}" aria-hidden="true">
        <span class="sample-ribbon">Fictional sample</span>
        <span class="art-orbit"></span><span class="art-shape"></span><span class="art-line"></span>
        <p>Original placeholder artwork</p>
    </div>
    <div class="detail-heading">
        <p class="eyebrow ink">{{ $item['template_label'] }}</p>
        <h1>{{ $item['title'] }}</h1>
        <ul class="attribute-list" aria-label="Fictional sample attributes">
            <li>{{ $item['area'] }}</li>
            <li>{{ $item['family'] ? 'Family filter: yes' : 'Family filter: no' }}</li>
            <li>Preview record</li>
        </ul>
        <p class="lead">{{ $item['description'] }}</p>
        <div class="sample-disclosure" role="note"><strong>Layout demonstration only.</strong> This page is not a real offer, recommendation or source of availability. Its fields are intentionally withheld until approved evidence exists.</div>
    </div>
</section>

<section class="container detail-layout">
    <div class="detail-content">
        <section class="detail-section" aria-labelledby="overview-heading">
            <p class="eyebrow ink">Overview</p>
            <h2 id="overview-heading">What a verified page will explain</h2>
            <p>This category-aware template reserves space for concise, decision-useful information. Publication requires a named source, permitted content, editorial review and a recorded verification date.</p>
        </section>

        <section class="detail-section" aria-labelledby="fields-heading">
            <p class="eyebrow ink">Required evidence</p>
            <h2 id="fields-heading">Fields awaiting verified sources</h2>
            <dl class="field-grid">
                @foreach($item['field_labels'] as $label)
                    <div><dt>{{ $label }}</dt><dd>Not supplied in this preview</dd></div>
                @endforeach
            </dl>
        </section>

        <section class="detail-section decision-note" aria-labelledby="before-heading">
            <p class="eyebrow ink">Before you choose</p>
            <h2 id="before-heading">Why these details are disabled</h2>
            <p>{{ $item['decision_note'] }}</p>
        </section>
    </div>

    <aside class="detail-action" aria-labelledby="action-heading">
        <p class="eyebrow ink">Referral status</p>
        <h2 id="action-heading">No live option yet</h2>
        <p>No partner, price, schedule or availability has been connected to this fictional sample.</p>
        <button type="button" disabled aria-disabled="true">{{ $item['cta_label'] }}</button>
        <small>The action will only be enabled after source, rights, disclosure and partner checks pass.</small>
        <a href="{{ route('category', $item['category']) }}">Back to {{ strtolower($category['name']) }} samples</a>
    </aside>
</section>

<section class="related-section">
    <div class="container">
        <div class="section-heading"><div><p class="eyebrow ink">More layout examples</p><h2>Related {{ strtolower($category['name']) }} samples</h2></div><p>Fictional records only</p></div>
        <div class="related-grid">
            @foreach($related as $relatedItem)
                <article>
                    <p>{{ $relatedItem['area'] }} · Sample layout</p>
                    <h3><a href="{{ route('experience.detail', ['category' => $relatedItem['category'], 'location' => $relatedItem['location_slug'], 'experience' => $relatedItem['id']]) }}">{{ $relatedItem['title'] }}</a></h3>
                    <span>No live offer or price</span>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
