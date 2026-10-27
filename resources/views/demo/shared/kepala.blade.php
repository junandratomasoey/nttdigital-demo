{{-- Kepala halaman dalam: $judul, $sub (opsional) --}}
<section class="motif bg-c text-white">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 md:py-16">
        <nav class="mb-3 text-xs text-white/70" aria-label="Breadcrumb">
            <a href="/" class="hover:text-white">Beranda</a> <span aria-hidden="true">/</span> <span class="text-white/90">{{ $judul }}</span>
        </nav>
        <h1 class="font-display text-3xl font-bold md:text-5xl">{{ $judul }}</h1>
        @isset($sub)<p class="mt-3 max-w-2xl text-white/80">{{ $sub }}</p>@endisset
    </div>
</section>
