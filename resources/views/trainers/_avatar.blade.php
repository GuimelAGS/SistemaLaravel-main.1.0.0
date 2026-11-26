@php
    $size = $size ?? 50;
    $initials = strtoupper(mb_substr($trainer->name ?? '', 0, 1) . mb_substr($trainer->apellido ?? '', 0, 1));
@endphp

@if ($trainer->avatar_url)
    <img src="{{ $trainer->avatar_url }}"
         alt="Avatar de {{ $trainer->name }}"
         class="rounded-circle"
         style="width: {{ $size }}px; height: {{ $size }}px; object-fit: cover; background-color: #EFEFEF;">
@else
    <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-secondary text-white fw-bold"
         style="width: {{ $size }}px; height: {{ $size }}px; font-size: {{ (int) ($size / 2.8) }}px;">
        {{ $initials ?: '?' }}
    </div>
@endif