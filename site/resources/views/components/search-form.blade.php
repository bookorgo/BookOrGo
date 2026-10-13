@props(['value' => ''])
<form class="search-form" method="get" action="{{ route('search') }}" role="search">
    <div class="search-field"><span class="search-icon" aria-hidden="true">⌕</span><label for="discovery-query">Destination or experience</label><input id="discovery-query" aria-label="What would you like to explore?" name="q" type="search" maxlength="120" value="{{ $value }}" placeholder="Where are you going?" autocomplete="off"></div>
    <div class="search-preview-field"><span aria-hidden="true">▦</span><label for="preview-date">When</label><input id="preview-date" placeholder="Dates not available" disabled aria-label="Dates not available in this preview"></div>
    <div class="search-preview-field traveller-preview"><span aria-hidden="true">♙</span><label for="preview-travellers">Travellers</label><input id="preview-travellers" placeholder="Not available yet" disabled aria-label="Traveller selection not available in this preview"></div>
    <button type="submit">Explore <span aria-hidden="true">→</span></button>
</form>
