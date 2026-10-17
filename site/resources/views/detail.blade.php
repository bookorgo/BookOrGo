@extends('layouts.app')
@section('page_class', 'page-detail')
@section('title', $item['title'].' | '.$category['name'].' | BookOrGo')
@section('meta_description', 'A clearly labelled fictional BookOrGo detail-page sample. No live offer, price, availability, advice or booking is provided.')
@section('content')
<section class="container detail-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span>
    <a href="{{ route('category', $item['category']) }}">{{ $category['name'] }}</a><span aria-hidden="true">/</span>
    <span>{{ $item['title'] }}</span>
</section>

<section class="container detail-hero">
    <div class="detail-gallery" role="group" aria-label="Illustrative UAE destination gallery — not photographs of this sample">
        <div class="detail-art card-{{ $item['motif'] }}"><x-photo :motif="$item['motif']" :eager="true" image-slot="detail-main" /><div class="gallery-summary"><strong>Not rated</strong><span>No verified reviews</span><hr><b>Guest feedback</b><p>This fictional sample has no verified guest feedback. No rating or quotation is invented.</p><small>Fictional sample</small></div><p>Destination photo · Not this sample</p></div>
        @foreach(['marina','dubai','desert','abu-dhabi','mountains','fujairah'] as $photo)<div class="gallery-tile"><x-photo :name="$photo" :image-slot="$loop->index < 2 ? 'detail-tall' : 'detail-small'" />@if($loop->last)<span>Destination photos<br>Illustrative only</span>@endif</div>@endforeach
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
    </div>
</section>

<nav class="container detail-section-nav" aria-label="Detail page sections"><a href="#overview-heading">Overview</a><a href="#fields-heading">Practical information</a><a href="#location-heading">Location</a><a href="#faq-heading">Questions</a></nav>

<section class="container detail-layout">
    <div class="detail-content">
        <div class="sample-disclosure" role="note"><strong>Layout demonstration only.</strong> This page is not a real offer, recommendation or source of availability. Its fields are intentionally withheld until approved evidence exists.</div>
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

        <section class="detail-section" aria-labelledby="location-heading">
            <p class="eyebrow ink">Location & getting there</p><h2 id="location-heading">A place for verified directions</h2>
            <div class="location-placeholder"><span aria-hidden="true">⌖</span><strong>{{ $item['area'] }} · Sample area label</strong><p>No verified address, coordinates, meeting point or map is attached.</p></div>
            <p>Directions, transport context and accessibility must be checked before release. No external map or location tracking is loaded in this preview.</p>
        </section>
<section class="detail-section review-preview" aria-labelledby="reviews-heading"><h2 id="reviews-heading">User ratings</h2><p>No verified ratings or reviews are available for this fictional sample.</p><div class="review-metrics">@foreach(['Overall experience','Facilities','Quality of service','Ease of access'] as $metric)<div><span>{{ $metric }}</span><strong>Not rated</strong><div class="unrated-track"></div></div>@endforeach</div><h2>What guests loved most</h2><div class="review-empty-grid"><div><span class="review-avatar" aria-hidden="true">—</span><strong>No guest reviews yet</strong><p>Verified guest feedback has not been supplied.</p></div><div><span class="review-avatar" aria-hidden="true">—</span><strong>Reviews awaiting verification</strong><p>No customer quotation or rating is invented.</p></div></div></section>
<section class="detail-section"><h2>Destination photos</h2><p class="image-context">Illustrative UAE imagery, not traveller photos of this sample.</p><div class="traveller-photo-row"><x-photo image-slot="detail-row" name="dubai" /><x-photo image-slot="detail-row" name="marina" /><x-photo image-slot="detail-row" name="desert" /></div></section>
<section class="detail-section detail-faq" aria-labelledby="faq-heading">
            <p class="eyebrow ink">Before you decide</p><h2 id="faq-heading">Frequently asked questions</h2>
            <details><summary>Can I book this sample?</summary><p>No. This is a fictional layout record. The referral control stays disabled until a real offer and approved partner link are verified.</p></details>
            <details><summary>Where are the prices and availability?</summary><p>They are withheld. No live price, schedule, inventory, discount or review is attached to this sample.</p></details>
            <details><summary>Who would handle a future booking?</summary><p>A clearly identified external partner would handle checkout, confirmation and support under its terms. BookOrGo has no active checkout in this preview.</p></details>
            <details><summary>Are these photographs of the experience?</summary><p>No. These are credited UAE destination photographs used as illustrative imagery. They do not depict or verify this fictional sample experience.</p></details>
        </section>
        <section class="detail-section detail-disclosure"><h2>Referral & content disclosure</h2><p>No affiliate link is active here. Real source-backed information, media permissions and partner disclosures must pass review before publication. <a href="{{ route('information', 'disclosure') }}">Read the disclosure preview</a>.</p></section>
    </div>

    <aside class="detail-action" aria-labelledby="action-heading">
<p class="eyebrow ink">Referral status</p><h2>Tickets and options</h2><p>Dates and options are not available for this sample.</p><div class="date-preview" role="group" aria-label="Inactive date preview">@foreach(range(1,4) as $slot)<button type="button" disabled aria-label="Date unavailable"><small>Date</small><strong>—</strong><span>Unavailable</span></button>@endforeach</div><div class="ticket-preview">
        <h2 id="action-heading">No live option yet</h2>
        <p>No partner, price, schedule or availability has been connected to this fictional sample.</p>
        <button type="button" disabled aria-disabled="true">{{ $item['cta_label'] }}</button>
        <small>The action will only be enabled after source, rights, disclosure and partner checks pass.</small>
        </div><a href="{{ route('category', $item['category']) }}">Back to {{ strtolower($category['name']) }} samples</a>
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
