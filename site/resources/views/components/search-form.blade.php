@props(['value' => ''])
<form class="search-form" method="get" action="{{ route('search') }}" role="search">
    <div class="search-field"><label for="discovery-query">What would you like to explore?</label><input id="discovery-query" name="q" type="search" maxlength="120" value="{{ $value }}" placeholder="Try activities, yachts or a UAE break" autocomplete="off"></div>
    <button type="submit">Explore <span aria-hidden="true">→</span></button>
</form>
