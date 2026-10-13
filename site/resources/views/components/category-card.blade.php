@props(['slug', 'category'])
<a class="category-card card-{{ $category['motif'] }}" href="{{ route('category', $slug) }}">
    <div class="category-art" aria-hidden="true"><x-scene :motif="$category['motif']" /></div>
    <div class="card-copy"><h3>{{ $category['name'] }} <span aria-hidden="true">↗</span></h3><p>{{ $category['description'] }}</p><span class="card-action">Explore category <span aria-hidden="true">→</span></span></div>
</a>
