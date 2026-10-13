@props(['motif' => 'arch', 'name' => null, 'variant' => 0, 'eager' => false])
@php
    $photos = ['arch'=>'dubai', 'sun'=>'desert', 'ship'=>'sharjah', 'sail'=>'marina', 'spark'=>'mountains', 'passport'=>'abu-dhabi'];
    $photo = $name ?? $photos[$motif] ?? 'dubai';
    if (!in_array($photo, ['dubai','desert','marina','mountains','abu-dhabi','sharjah','fujairah'], true)) $photo = 'dubai';
@endphp
<img class="scene destination-photo photo-variant-{{ $variant }}" src="{{ Vite::asset('resources/images/'.$photo.'.webp') }}" width="1400" height="933" alt="" loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async" @if($eager) fetchpriority="high" @endif>
