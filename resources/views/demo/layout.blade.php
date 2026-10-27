@php
    $font  = \App\Support\Tema::font($demo->jenis);
    $menu  = $demo->konfig('menu', []);
    $path  = '/' . ltrim(request()->path(), '/');
    $aktif = fn ($url) => $url === '/' ? $path === '/' : str_starts_with($path, $url);
    $judulHalaman = trim($__env->yieldContent('judul'));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judulHalaman ? $judulHalaman . ' – ' : '' }}{{ $demo->nama }}</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($demo->tagline ?: $demo->deskripsi, 155) }}">
    {{-- Website demo: jangan diindeks agar tidak bersaing dengan situs utama / dikira situs resmi --}}
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="{{ $demo->warna }}">
    <meta property="og:title" content="{{ $demo->nama }} — Demo {{ $demo->konfig('label') }} oleh NTT Digital">
    <meta property="og:description" content="{{ $demo->tagline }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?{{ $font['url'] }}&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}?v={{ filemtime(public_path('css/demo.css')) }}">
    <style>
        :root {
            --c: {{ $demo->warna }};
            --a: {{ $demo->warna_aksen }};
            --f-display: "{{ $font['display'] }}";
            --f-body: "{{ $font['body'] }}";
        }
    </style>
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>
    @stack('head')
</head>
<body class="antialiased {{ trim($__env->yieldContent('body-class')) ?: 'bg-white text-stone-800' }}">

    @include('demo.shared.banner-demo')

    @unless($demo->jenis === 'undangan')
    <header class="sticky top-0 z-40 border-b border-stone-200/80 bg-white/95 backdrop-blur" x-data="{ buka: false }" @keydown.escape.window="buka = false">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6">
            <a href="/" class="flex min-w-0 items-center gap-3">
                <span class="motif grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-c font-display text-lg font-bold text-white">{{ $demo->logo_teks }}</span>
                <span class="min-w-0 leading-tight">
                    <span class="block truncate font-display text-lg font-bold text-stone-900">{{ $demo->nama }}</span>
                    @if($demo->d('sub_nama'))
                    <span class="block truncate text-xs text-stone-500">{{ $demo->d('sub_nama') }}</span>
                    @endif
                </span>
            </a>

            <nav class="hidden items-center gap-1 lg:flex" aria-label="Menu utama">
                @foreach($menu as [$label, $url])
                <a href="{{ $url }}" @if($aktif($url)) aria-current="page" @endif
                   class="rounded-full px-3 py-2 text-sm font-medium transition {{ $aktif($url) ? 'bg-c-soft text-c' : 'text-stone-600 hover:text-stone-900' }}">{{ $label }}</a>
                @endforeach
            </nav>

            <button class="rounded-lg p-2 text-stone-700 lg:hidden" @click="buka = !buka" :aria-expanded="buka" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path x-show="!buka" stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/><path x-cloak x-show="buka" stroke-linecap="round" d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <nav x-cloak x-show="buka" x-transition class="border-t border-stone-100 px-4 pb-4 lg:hidden" aria-label="Menu utama">
            @foreach($menu as [$label, $url])
            <a href="{{ $url }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium {{ $aktif($url) ? 'bg-c-soft text-c' : 'text-stone-700' }}">{{ $label }}</a>
            @endforeach
        </nav>
    </header>
    @endunless

    <main id="konten">
        @yield('konten')
    </main>

    @unless($demo->jenis === 'undangan')
    <footer class="motif bg-c-deep text-white/80">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-3">
            <div>
                <div class="font-display text-xl font-bold text-white">{{ $demo->nama }}</div>
                <p class="mt-3 text-sm leading-relaxed">{{ $demo->tagline }}</p>
            </div>
            <div class="text-sm">
                <div class="mb-3 font-semibold uppercase tracking-wider text-white">Kontak</div>
                <ul class="space-y-2">
                    @if($demo->alamat)<li>{{ $demo->alamat }}</li>@endif
                    @if($demo->telepon)<li>Telp. {{ $demo->telepon }}</li>@endif
                    @if($demo->email)<li>{{ $demo->email }}</li>@endif
                    @if($demo->jam_layanan)<li>{{ $demo->jam_layanan }}</li>@endif
                </ul>
            </div>
            <div class="text-sm">
                <div class="mb-3 font-semibold uppercase tracking-wider text-white">Tautan</div>
                <ul class="grid grid-cols-2 gap-2">
                    @foreach($menu as [$label, $url])
                    <li><a href="{{ $url }}" class="hover:text-white">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-5 text-xs text-white/60 sm:flex-row sm:justify-between sm:px-6">
                <span>© {{ date('Y') }} {{ $demo->nama }} · Nama &amp; data fiktif untuk demonstrasi</span>
                <a href="{{ config('demo.situs_utama') }}" class="hover:text-white">Website by NTT Digital</a>
            </div>
        </div>
    </footer>
    @endunless

    @stack('scripts')
</body>
</html>
