{{--
    Gambar dengan cadangan bermotif tenun bila belum ada foto.
    <x-gambar :src="$item->gambar" :label="$item->nama" class="aspect-[4/3]" :warna="$item->d('warna')" />
--}}
@props(['src' => null, 'label' => '', 'warna' => null, 'ikon' => null])
@php $lebar = preg_match('/(^|\s)w-/', (string) $attributes->get('class')) ? '' : 'w-full '; @endphp
@if($src)
    <img src="{{ str_starts_with($src, 'http') ? $src : asset('storage/' . $src) }}" alt="{{ $label }}" loading="lazy"
         {{ $attributes->merge(['class' => $lebar . 'object-cover']) }}>
@else
    <div role="img" aria-label="{{ $label }}"
         {{ $attributes->merge(['class' => $lebar . 'motif relative grid place-items-center overflow-hidden']) }}
         style="background: linear-gradient(135deg, {{ $warna ?: 'var(--c)' }}, color-mix(in srgb, {{ $warna ?: 'var(--c)' }} 55%, var(--a)));">
        @if($ikon)
            <span class="text-5xl drop-shadow-sm" aria-hidden="true">{{ $ikon }}</span>
        @else
            <span class="px-4 text-center font-display text-lg font-semibold text-white/90 drop-shadow-sm">{{ $label }}</span>
        @endif
    </div>
@endif
