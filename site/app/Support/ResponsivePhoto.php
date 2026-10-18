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
        $px = static fn (float $value): string => number_format($value, 2, '.', '').'px';
        // Use ordered media conditions instead of nested min()/max() in sizes.
        // Some engines accept those CSS functions but ignore them in image sizes.
        $segment = static function (int $limit, float $vw, float $subtract, int $height) use ($ratio, $px): string {
            $floor = $height * $ratio;
            $crossing = ($floor + $subtract) * 100 / $vw;
            if ($crossing >= $limit) {
                return '(max-width: '.$limit.'px) '.$px($floor).', ';
            }
            return '(max-width: '.$px($crossing).') '.$px($floor).', (max-width: '.$limit.'px) calc('.$vw.'vw - '.$subtract.'px), ';
        };
        // sizes represents the source pixels needed for object-fit:cover, including tall cells.
        // Home reuses each source in several frames. A shared per-photo envelope avoids
        // downloading different derivatives of the same photograph on one page.
        $homeFactor = max(1, $ratio / 1.22);
        $sizes = match ($slot) {
            'home' => $segment(360, 100, 32, 180)
                .$segment(720, 50 * $homeFactor, 22 * $homeFactor, 155)
                .$segment(900, 50, 30, 224)
                .$px(max(374, 215 * $ratio, $name === 'dubai' ? 301 * $ratio : 0)),
            // Include the taller inspiration tiles, not only the result-card width.
            'listing' => '(max-width: 720px) '.$px(max(112, 180 * $ratio)).', '.$px(max(247, 300 * $ratio)),
            'detail-main' => $segment(720, 100, 32, 220).$segment(900, 60, 36, 338).$px(max(639, 478 * $ratio)),
            'detail-tall' => $segment(720, 33.333, 14, 80).$segment(900, 20, 12, 166).$px(max(213, 236 * $ratio)),
            'detail-small' => $segment(720, 33.333, 14, 80).$segment(900, 20, 12, 80).$px(max(213, 115 * $ratio)),
            'detail-row' => $segment(720, 33.333, 16, 105).$px(max(240, 185 * $ratio)),
            default => throw new \InvalidArgumentException('Unknown responsive photo slot'),
        };

        return ['variants' => $photo['variants'], 'sizes' => $sizes];
    }
}
