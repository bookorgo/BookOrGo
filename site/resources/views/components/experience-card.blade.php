@props(['item', 'categories', 'durations'])
<article class="experience-card">
    <div class="experience-art card-{{ $item['motif'] }}" aria-hidden="true">
        <span class="sample-ribbon">Sample layout</span>
        <span class="art-orbit"></span><span class="art-shape"></span><span class="art-line"></span>
    </div>
    <div class="experience-copy">
        <div class="card-kicker"><span>{{ $categories[$item['category']]['name'] }}</span><span>Fictional sample</span></div>
        <h2>{{ $item['title'] }}</h2>
        <ul class="attribute-list" aria-label="Sample filter attributes">
            <li>{{ $item['area'] }}</li>
            <li>{{ $durations[$item['duration']] }}</li>
            <li>{{ $item['family'] ? 'Family filter: yes' : 'Family filter: no' }}</li>
        </ul>
        <p>{{ $item['description'] }}</p>
        <div class="card-footer">
            <strong>No live offer or price</strong>
            <a class="detail-link" href="{{ route('experience.detail', ['category' => $item['category'], 'location' => $item['location_slug'], 'experience' => $item['id']]) }}">View sample detail <span aria-hidden="true">→</span></a>
        </div>
    </div>
</article>
