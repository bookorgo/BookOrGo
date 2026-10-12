@extends('layouts.smoke')

@section('content')
<article class="mx-auto grid max-w-6xl gap-10 px-5 py-12 lg:grid-cols-[1fr_20rem]">
    <div>
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-blue-700">Activities · Dubai · sample</p>
        <h1 class="mt-3 text-4xl font-black tracking-tight">Sample Dubai activity detail</h1>
        <p class="mt-5 max-w-2xl text-lg text-slate-700">A server-rendered detail template for structure and accessibility checks. Facts, prices and availability are intentionally omitted until source evidence and rights are approved.</p>
        <section aria-labelledby="facts" class="mt-10 rounded-2xl border border-slate-200 bg-white p-6">
            <h2 id="facts" class="text-xl font-black">What visitors will verify here</h2>
            <ul class="mt-4 list-disc space-y-2 pl-5 text-slate-700">
                <li>Current location and practical entry details from attributable sources</li>
                <li>Comparable ticket options only when scope and freshness are verified</li>
                <li>Relevant FAQs and related Dubai planning links</li>
            </ul>
        </section>
    </div>
    <aside aria-label="Sample partner state" class="h-fit rounded-2xl border border-amber-300 bg-amber-50 p-6">
        <h2 class="text-lg font-black">No live offer</h2>
        <p class="mt-2 text-sm text-slate-700">Partner approval, destination, price and availability have not been supplied for this preview.</p>
        <button class="mt-5 w-full cursor-not-allowed rounded-xl bg-slate-300 px-4 py-3 font-bold text-slate-600" type="button" disabled>Partner link unavailable in sample</button>
    </aside>
</article>
@endsection
