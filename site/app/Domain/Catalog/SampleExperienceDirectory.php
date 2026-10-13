<?php

namespace App\Domain\Catalog;

use InvalidArgumentException;

/**
 * Explicitly fictional catalogue records used only to exercise the P1 frontend.
 * Nothing here is an offer, price, availability claim or partner-supplied record.
 */
final class SampleExperienceDirectory
{
    private const PER_PAGE = 6;

    public function __construct(private CategoryDirectory $categories) {}

    public function browse(array $input, ?string $fixedCategory = null): array
    {
        $filters = [
            'q' => $this->string($input, 'q', 120),
            'category' => $fixedCategory ?? $this->choice($input, 'category', array_keys($this->categories->all())),
            'area' => $this->choice($input, 'area', $this->areas()),
            'duration' => $this->choice($input, 'duration', array_keys($this->durations())),
            'family' => $this->choice($input, 'family', ['yes', 'no']),
            'sort' => $this->choice($input, 'sort', ['recommended', 'title-asc', 'title-desc']) ?: 'recommended',
        ];
        $page = $this->positiveInteger($input, 'page');

        $items = array_values(array_filter($this->items(), function (array $item) use ($filters): bool {
            if ($filters['category'] !== '' && $item['category'] !== $filters['category']) {
                return false;
            }
            if ($filters['area'] !== '' && $item['area'] !== $filters['area']) {
                return false;
            }
            if ($filters['duration'] !== '' && $item['duration'] !== $filters['duration']) {
                return false;
            }
            if ($filters['family'] !== '' && $item['family'] !== ($filters['family'] === 'yes')) {
                return false;
            }
            if ($filters['q'] === '') {
                return true;
            }

            $haystack = implode(' ', [
                $item['title'],
                $item['area'],
                $item['category'],
                implode(' ', $item['tags']),
            ]);

            return str_contains(mb_strtolower($haystack), mb_strtolower($filters['q']));
        }));

        usort($items, match ($filters['sort']) {
            'title-asc' => fn (array $left, array $right): int => [$left['title'], $left['id']] <=> [$right['title'], $right['id']],
            'title-desc' => fn (array $left, array $right): int => [$right['title'], $right['id']] <=> [$left['title'], $left['id']],
            default => fn (array $left, array $right): int => [$left['order'], $left['id']] <=> [$right['order'], $right['id']],
        });

        $lastPage = max(1, (int) ceil(count($items) / self::PER_PAGE));
        if ($page > $lastPage) {
            throw new InvalidArgumentException('That results page is not available.');
        }

        return [
            'items' => array_slice($items, ($page - 1) * self::PER_PAGE, self::PER_PAGE),
            'total' => count($items),
            'page' => $page,
            'perPage' => self::PER_PAGE,
            'lastPage' => $lastPage,
            'filters' => $filters,
            'areas' => $this->areas(),
            'durations' => $this->durations(),
        ];
    }

    public function detail(string $category, string $location, string $id): ?array
    {
        foreach ($this->items() as $item) {
            if ($item['category'] === $category && $item['location_slug'] === $location && $item['id'] === $id) {
                return [...$item, ...$this->detailBlueprint($category)];
            }
        }

        return null;
    }

    public function related(string $category, string $exceptId): array
    {
        return array_slice(array_values(array_filter(
            $this->items(),
            fn (array $item): bool => $item['category'] === $category && $item['id'] !== $exceptId,
        )), 0, 2);
    }

    private function string(array $input, string $key, int $maximum): string
    {
        $value = $input[$key] ?? '';
        if (! is_string($value) || mb_strlen($value) > $maximum) {
            throw new InvalidArgumentException('Enter a search of up to 120 characters.');
        }

        return trim($value);
    }

    private function choice(array $input, string $key, array $allowed): string
    {
        $value = $input[$key] ?? '';
        if (! is_string($value) || ($value !== '' && ! in_array($value, $allowed, true))) {
            throw new InvalidArgumentException('One or more filters could not be applied.');
        }

        return $value;
    }

    private function positiveInteger(array $input, string $key): int
    {
        $value = $input[$key] ?? '1';
        if (is_int($value)) {
            $value = (string) $value;
        }
        if (! is_string($value) || ! ctype_digit($value) || (int) $value < 1 || (int) $value > 100) {
            throw new InvalidArgumentException('Choose a valid results page.');
        }

        return (int) $value;
    }

    private function areas(): array
    {
        $areas = array_values(array_unique(array_column($this->items(), 'area')));
        sort($areas);

        return $areas;
    }

    private function durations(): array
    {
        return [
            'under-2-hours' => 'Under 2 hours',
            'half-day' => 'Half day',
            'full-day' => 'Full day',
            'multi-day' => 'Multi-day',
            'information' => 'Information guide',
        ];
    }

    private function items(): array
    {
        return array_map(function (array $item): array {
            $item['location_slug'] = mb_strtolower(str_replace([' ', '_'], '-', $item['area']));

            return $item;
        }, [
            ['id' => 'sample-desert-morning', 'title' => 'Desert morning activity concept', 'category' => 'activities', 'area' => 'Dubai', 'duration' => 'half-day', 'family' => true, 'order' => 10, 'motif' => 'sun', 'tags' => ['sample', 'desert', 'outdoors'], 'description' => 'A fictional card for testing activity discovery and filters.'],
            ['id' => 'sample-city-view', 'title' => 'City viewpoint activity concept', 'category' => 'activities', 'area' => 'Abu Dhabi', 'duration' => 'under-2-hours', 'family' => true, 'order' => 20, 'motif' => 'arch', 'tags' => ['sample', 'city', 'view'], 'description' => 'A fictional card for testing short activity results.'],
            ['id' => 'sample-mountain-day', 'title' => 'Mountain day activity concept', 'category' => 'activities', 'area' => 'Ras Al Khaimah', 'duration' => 'full-day', 'family' => false, 'order' => 30, 'motif' => 'spark', 'tags' => ['sample', 'mountain', 'adventure'], 'description' => 'A fictional card for testing outdoor activity states.'],
            ['id' => 'sample-city-break', 'title' => 'City break holiday concept', 'category' => 'holidays', 'area' => 'Dubai', 'duration' => 'multi-day', 'family' => true, 'order' => 40, 'motif' => 'arch', 'tags' => ['sample', 'break', 'city'], 'description' => 'A fictional card for testing holiday discovery.'],
            ['id' => 'sample-coast-break', 'title' => 'East coast holiday concept', 'category' => 'holidays', 'area' => 'Fujairah', 'duration' => 'multi-day', 'family' => true, 'order' => 50, 'motif' => 'sail', 'tags' => ['sample', 'coast', 'break'], 'description' => 'A fictional card for testing coastal holiday filters.'],
            ['id' => 'sample-weekend-reset', 'title' => 'Weekend reset holiday concept', 'category' => 'holidays', 'area' => 'Sharjah', 'duration' => 'multi-day', 'family' => false, 'order' => 60, 'motif' => 'sun', 'tags' => ['sample', 'weekend', 'break'], 'description' => 'A fictional card for testing adult holiday states.'],
            ['id' => 'sample-tourist-visa-guide', 'title' => 'Tourist visa guide placeholder', 'category' => 'visas', 'area' => 'UAE-wide', 'duration' => 'information', 'family' => true, 'order' => 70, 'motif' => 'passport', 'tags' => ['sample', 'visa', 'information'], 'description' => 'A non-advisory placeholder for the future sourced visa guide layout.'],
            ['id' => 'sample-transit-visa-guide', 'title' => 'Transit visa guide placeholder', 'category' => 'visas', 'area' => 'UAE-wide', 'duration' => 'information', 'family' => false, 'order' => 80, 'motif' => 'passport', 'tags' => ['sample', 'visa', 'transit', 'information'], 'description' => 'A non-advisory placeholder with no eligibility or approval claim.'],
            ['id' => 'sample-visa-checklist', 'title' => 'Travel document checklist placeholder', 'category' => 'visas', 'area' => 'UAE-wide', 'duration' => 'information', 'family' => true, 'order' => 90, 'motif' => 'passport', 'tags' => ['sample', 'visa', 'documents', 'information'], 'description' => 'A fictional information card awaiting verified official sources.'],
            ['id' => 'sample-creek-cruise', 'title' => 'Creek cruise layout concept', 'category' => 'cruises', 'area' => 'Dubai', 'duration' => 'under-2-hours', 'family' => true, 'order' => 100, 'motif' => 'ship', 'tags' => ['sample', 'boat', 'water'], 'description' => 'A fictional card for testing cruise discovery.'],
            ['id' => 'sample-marina-cruise', 'title' => 'Marina cruise layout concept', 'category' => 'cruises', 'area' => 'Dubai Marina', 'duration' => 'half-day', 'family' => true, 'order' => 110, 'motif' => 'ship', 'tags' => ['sample', 'boat', 'marina', 'water'], 'description' => 'A fictional card with no operator, timetable or availability claim.'],
            ['id' => 'sample-coast-cruise', 'title' => 'Coastal cruise layout concept', 'category' => 'cruises', 'area' => 'Abu Dhabi', 'duration' => 'full-day', 'family' => false, 'order' => 120, 'motif' => 'ship', 'tags' => ['sample', 'boat', 'coast', 'water'], 'description' => 'A fictional card for testing longer cruise filters.'],
            ['id' => 'sample-marina-yacht', 'title' => 'Marina yacht layout concept', 'category' => 'yachts', 'area' => 'Dubai Marina', 'duration' => 'under-2-hours', 'family' => true, 'order' => 130, 'motif' => 'sail', 'tags' => ['sample', 'boat', 'yacht', 'marina'], 'description' => 'A fictional card with no charter or availability claim.'],
            ['id' => 'sample-sunset-yacht', 'title' => 'Sunset yacht layout concept', 'category' => 'yachts', 'area' => 'Dubai', 'duration' => 'half-day', 'family' => false, 'order' => 140, 'motif' => 'sail', 'tags' => ['sample', 'boat', 'yacht', 'water'], 'description' => 'A fictional card for testing yacht discovery states.'],
            ['id' => 'sample-island-yacht', 'title' => 'Island yacht layout concept', 'category' => 'yachts', 'area' => 'Abu Dhabi', 'duration' => 'full-day', 'family' => true, 'order' => 150, 'motif' => 'sail', 'tags' => ['sample', 'boat', 'yacht', 'island'], 'description' => 'A fictional card for testing family filters.'],
            ['id' => 'sample-family-event', 'title' => 'Family event layout concept', 'category' => 'events', 'area' => 'Dubai', 'duration' => 'half-day', 'family' => true, 'order' => 160, 'motif' => 'spark', 'tags' => ['sample', 'event', 'family'], 'description' => 'A fictional card with no date, ticket or availability claim.'],
            ['id' => 'sample-cultural-event', 'title' => 'Cultural event layout concept', 'category' => 'events', 'area' => 'Sharjah', 'duration' => 'full-day', 'family' => true, 'order' => 170, 'motif' => 'spark', 'tags' => ['sample', 'event', 'culture'], 'description' => 'A fictional card awaiting a verified event source.'],
            ['id' => 'sample-evening-event', 'title' => 'Evening event layout concept', 'category' => 'events', 'area' => 'Abu Dhabi', 'duration' => 'under-2-hours', 'family' => false, 'order' => 180, 'motif' => 'spark', 'tags' => ['sample', 'event', 'evening'], 'description' => 'A fictional card with no schedule or ticket claim.'],
        ]);
    }

    private function detailBlueprint(string $category): array
    {
        return match ($category) {
            'activities' => [
                'template_label' => 'Activity detail template',
                'field_labels' => ['Ticket variant', 'Age rules', 'Operating times', 'Meeting or pickup point', 'Inclusions', 'Accessibility'],
                'decision_note' => 'Times, access rules and what is included must come from an approved current source before this page can become a real activity listing.',
                'cta_label' => 'Check verified activity options',
            ],
            'holidays' => [
                'template_label' => 'Holiday detail template',
                'field_labels' => ['Itinerary', 'Number of nights', 'Accommodation basis', 'Travel window', 'Inclusions and exclusions', 'Guest limits'],
                'decision_note' => 'Accommodation, dates, guest limits and package inclusions must be verified together before a holiday referral can be enabled.',
                'cta_label' => 'Check verified holiday options',
            ],
            'visas' => [
                'template_label' => 'Visa information template',
                'field_labels' => ['Visa type', 'Applicant eligibility', 'Required documents', 'Processing range', 'Official source', 'Last verified date'],
                'decision_note' => 'This placeholder is not immigration advice. Eligibility, documents, timelines and any referral route require current official sources and editorial review.',
                'cta_label' => 'View verified visa guidance',
            ],
            'cruises' => [
                'template_label' => 'Cruise detail template',
                'field_labels' => ['Route', 'Boarding point', 'Duration', 'Departure time', 'Dining options', 'Inclusions'],
                'decision_note' => 'The route, boarding instructions, timing and inclusions must be supplied and checked before a cruise referral can be shown.',
                'cta_label' => 'Check verified cruise options',
            ],
            'yachts' => [
                'template_label' => 'Yacht detail template',
                'field_labels' => ['Capacity', 'Rental duration', 'Boarding point', 'Inclusions', 'Optional add-ons', 'Package constraints'],
                'decision_note' => 'Capacity, operator terms, boarding details and package constraints must be verified before a yacht referral can be enabled.',
                'cta_label' => 'Check verified yacht options',
            ],
            'events' => [
                'template_label' => 'Event detail template',
                'field_labels' => ['Event date', 'Venue', 'Ticket category', 'Age restrictions', 'Access policy', 'Official source'],
                'decision_note' => 'Dates, venue access, age rules and ticket categories must be checked against an approved source before publication.',
                'cta_label' => 'Check verified event options',
            ],
            default => throw new InvalidArgumentException('Unknown detail category.'),
        };
    }
}
