@props(['motif' => 'arch', 'name' => null, 'variant' => 0, 'eager' => false, 'imageSlot' => null])
@php
    $photos = ['arch'=>'dubai', 'sun'=>'desert', 'ship'=>'sharjah', 'sail'=>'marina', 'spark'=>'mountains', 'passport'=>'abu-dhabi'];
    $photo = $name ?? $photos[$motif] ?? 'dubai';
    if (!in_array($photo, ['dubai','desert','marina','mountains','abu-dhabi','sharjah','fujairah'], true)) $photo = 'dubai';
    $responsive = $imageSlot ? \App\Support\ResponsivePhoto::forSlot($photo, $imageSlot) : null;
@endphp
<img class="scene destination-photo photo-variant-{{ $variant }}" src="{{ Vite::asset('resources/images/'.$photo.'.webp') }}" @if($responsive) srcset="{{ collect($responsive['variants'])->map(fn ($image) => Vite::asset($image['path']).' '.$image['width'].'w')->implode(', ') }}" sizes="{{ $responsive['sizes'] }}" @endif width="1400" height="933" alt="" loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async" @if($eager) fetchpriority="high" @endif>
