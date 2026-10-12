@extends('layouts.smoke')

@section('content')
<section class="bg-blue-700 text-white">
    <div class="mx-auto max-w-6xl px-5 py-16 sm:py-24">
        <p class="mb-3 text-sm font-bold uppercase tracking-[0.2em] text-blue-100">Dubai & UAE sample</p>
        <h1 class="max-w-3xl text-4xl font-black tracking-tight sm:text-6xl">Plan what to explore, then book with an approved partner</h1>
        <p class="mt-5 max-w-2xl text-lg text-blue-100">This protected preview verifies server-rendered discovery content. It contains no live inventory or offers.</p>
    </div>
</section>
<section aria-labelledby="categories" class="mx-auto max-w-6xl px-5 py-12">
    <h2 id="categories" class="text-2xl font-black">Explore six planned categories</h2>
    <ul class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach (['Activities', 'Holidays', 'Visas', 'Cruises', 'Yachts', 'Events'] as $category)
            <li class="rounded-2xl border border-slate-200 bg-white p-5 font-bold shadow-sm">{{ $category }} <span class="block pt-2 text-sm font-normal text-slate-500">Sample navigation label</span></li>
        @endforeach
    </ul>
</section>
@endsection
