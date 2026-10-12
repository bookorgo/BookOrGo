<?php

namespace App\Domain\Catalog;

/** Public taxonomy only. These entries are not products, offers or inventory. */
final class CategoryDirectory
{
    public function all(): array
    {
        return [
            'activities' => ['name' => 'Activities', 'eyebrow' => 'Make a day of it', 'description' => 'A place to explore things to do across Dubai and the UAE.', 'motif' => 'sun', 'keywords' => 'attractions sightseeing adventure desert experiences'],
            'holidays' => ['name' => 'Holidays', 'eyebrow' => 'A little change of scene', 'description' => 'A home for UAE breaks and holiday inspiration.', 'motif' => 'arch', 'keywords' => 'break stay travel trip staycation'],
            'visas' => ['name' => 'Visas', 'eyebrow' => 'Start with the essentials', 'description' => 'A space for clearly sourced UAE visa information.', 'motif' => 'passport', 'keywords' => 'entry travel documents information'],
            'cruises' => ['name' => 'Cruises', 'eyebrow' => 'See another side of the city', 'description' => 'Discover the cruise category for Dubai and the UAE.', 'motif' => 'ship', 'keywords' => 'boat sea water dhow sailing'],
            'yachts' => ['name' => 'Yachts', 'eyebrow' => 'Out on the water', 'description' => 'Explore the yacht category and plan your next idea.', 'motif' => 'sail', 'keywords' => 'boat sea water sailing charter'],
            'events' => ['name' => 'Events', 'eyebrow' => 'Find your next occasion', 'description' => 'A space for events and experiences around the UAE.', 'motif' => 'spark', 'keywords' => 'concert festival entertainment show'],
        ];
    }

    public function search(string $query): array
    {
        if ($query === '') {
            return $this->all();
        }

        return array_filter($this->all(), fn (array $category) =>
            str_contains(mb_strtolower(implode(' ', $category)), mb_strtolower($query))
        );
    }
}
