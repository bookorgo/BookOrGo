<?php

namespace App\Support;

final class ResponsivePhoto
{
    public static function forSlot(string $name, string $slot): array
    {
        static $manifest;
        $manifest ??= json_decode(file_get_contents(resource_path('images/responsive/manifest.json')), true, flags: JSON_THROW_ON_ERROR);
        $photo = $manifest[$name];
        $ratio = $photo['width'] / $photo['height'];
        $cover = static fn (int $height): string => number_format($height * $ratio, 2, '.', '').'px';
        // sizes represents the source pixels needed for object-fit:cover, including tall cells.
        $sizes = match ($slot) {
            'detail-main' => '(max-width: 720px) max(calc(100vw - 32px), '.$cover(220).'), (max-width: 900px) max(calc(60vw - 36px), '.$cover(338).'), max(min(calc(60vw - 36px), 639px), '.$cover(478).')',
            'detail-tall' => '(max-width: 720px) max(calc(33.333vw - 14px), '.$cover(80).'), (max-width: 900px) max(calc(20vw - 12px), '.$cover(166).'), max(min(calc(20vw - 12px), 213px), '.$cover(236).')',
            'detail-small' => '(max-width: 720px) max(calc(33.333vw - 14px), '.$cover(80).'), (max-width: 900px) max(calc(20vw - 12px), '.$cover(80).'), max(min(calc(20vw - 12px), 213px), '.$cover(115).')',
            'detail-row' => '(max-width: 720px) max(calc(33.333vw - 16px), '.$cover(105).'), max(240px, '.$cover(185).')',
            default => throw new \InvalidArgumentException('Unknown responsive photo slot'),
        };

        return ['variants' => $photo['variants'], 'sizes' => $sizes];
    }
}
