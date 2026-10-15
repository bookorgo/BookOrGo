export function distribution(values) {
    if (values.length !== 3 || values.some(value => !Number.isFinite(value))) {
        throw new Error('A baseline requires three finite measurements');
    }
    const sorted = [...values].sort((a, b) => a - b);
    return { min: sorted[0], median: sorted[1], max: sorted[2] };
}

export function summarize(rows) {
    const groups = [];
    for (const profile of ['mobile', 'desktop']) {
        for (const page of ['home', 'listing', 'detail', 'article']) {
            const samples = rows.filter(row => row.profile === profile && row.page === page);
            const metrics = Object.fromEntries(['score', 'lcpMs', 'fcpMs', 'tbtMs', 'cls', 'speedIndexMs', 'transferBytes'].map(key => [key, distribution(samples.map(row => row[key]))]));
            groups.push({ profile, page, metrics, labTargets: { lcpMedianWithin2500ms: metrics.lcpMs.median <= 2500, clsMedianWithin01: metrics.cls.median <= .1 } });
        }
    }
    return groups;
}
