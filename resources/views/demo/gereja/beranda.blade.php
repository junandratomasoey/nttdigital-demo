@extends('demo.layout')
@section('konten')
@php
    $jadwal = $demo->itemsTipe('jadwal');
    $pelayanan = $demo->itemsTipe('pelayanan');
    $renungan = \App\Models\Post::terbit()->where('kategori', 'Renungan')->first();
    $warta = \App\Models\Post::terbit()->where('kategori', '!=', 'Renungan')->take(3)->get();
@endphp

<section class="motif bg-c-deep text-white">
    <div class="mx-auto max-w-4xl px-4 py-20 text-center sm:px-6 md:py-28">
        <p class="text-sm uppercase tracking-[0.3em] text-a">{{ $demo->d('sub_nama') }}</p>
        <h1 class="mt-5 font-display text-5xl font-semibold leading-tight md:text-7xl">{{ $demo->hero_judul }}</h1>
        <p class="mx-auto mt-6 max-w-xl font-display text-xl italic text-white/80 md:text-2xl">“{{ $demo->d('ayat.teks') }}”</p>
        <p class="mt-2 text-sm tracking-wider text-a">{{ $demo->d('ayat.sumber') }}</p>
        <div class="mt-10 flex flex-wrap justify-center gap-3">
            <a href="/jadwal" class="btn-a">Jadwal ibadah</a>
            @if($demo->d('youtube'))<a href="{{ $demo->d('youtube') }}" target="_blank" rel="noopener" class="btn-garis text-white">Ibadah live streaming</a>@endif
        </div>
    </div>
</section>

<section class="relative -mt-10">
    <div class="mx-auto max-w-5xl px-4 sm:px-6">
        <div class="grid gap-px overflow-hidden rounded-2xl bg-stone-200 shadow-xl sm:grid-cols-3">
            @foreach($jadwal->take(3) as $j)
            <div class="bg-white p-6 text-center">
                <div class="text-xs font-bold uppercase tracking-widest text-c">{{ $j->subjudul }}</div>
                <div class="mt-2 font-display text-4xl font-semibold text-stone-900">{{ $j->d('jam') }}</div>
                <div class="mt-1 text-sm text-stone-600">{{ $j->nama }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-3">
        @if($renungan)
        <article class="rounded-2xl bg-a-soft p-8">
            <p class="label-seksi">Renungan Minggu Ini</p>
            <h2 class="mt-3 font-display text-3xl font-semibold leading-tight text-stone-900">{{ $renungan->judul }}</h2>
            <p class="mt-4 leading-relaxed text-stone-700">{{ $renungan->ringkas }}</p>
            <a href="/warta/{{ $renungan->slug }}" class="mt-5 inline-block font-semibold text-c hover:underline">Baca renungan →</a>
        </article>
        @endif
        <div class="lg:col-span-2">
            <div class="flex items-end justify-between gap-4">
                <h2 class="judul-seksi">Warta jemaat</h2>
                <a href="/warta" class="text-sm font-semibold text-c hover:underline">Semua warta →</a>
            </div>
            <div class="mt-6 divide-y divide-stone-200 border-y border-stone-200">
                @foreach($warta as $w)
                <a href="/warta/{{ $w->slug }}" class="flex gap-5 py-5 hover:bg-stone-50">
                    <div class="w-16 shrink-0 text-center">
                        <div class="font-display text-3xl font-semibold text-c">{{ $w->tanggal->format('d') }}</div>
                        <div class="text-xs uppercase text-stone-500">{{ $w->tanggal->translatedFormat('M') }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-a">{{ $w->kategori }}</div>
                        <div class="font-display text-xl font-semibold text-stone-900">{{ $w->judul }}</div>
                        <p class="mt-1 line-clamp-2 text-sm text-stone-600">{{ $w->ringkas }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-stone-50">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <h2 class="judul-seksi text-center">Pelayanan kategorial</h2>
        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($pelayanan as $p)
            <div class="rounded-2xl border border-stone-200 bg-white p-6 text-center">
                <div class="text-3xl" aria-hidden="true">{{ $p->ikon }}</div>
                <h3 class="mt-3 font-display text-2xl font-semibold text-stone-900">{{ $p->nama }}</h3>
                <p class="mt-2 text-sm text-stone-600">{{ $p->deskripsi }}</p>
                <p class="mt-3 text-xs font-semibold text-c">{{ $p->subjudul }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="motif bg-c text-white">
    <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-6 px-4 py-14 sm:px-6 md:flex-row md:items-center">
        <div>
            <h2 class="font-display text-4xl font-semibold">Butuh didoakan?</h2>
            <p class="mt-2 text-white/80">Kirim pokok doa Anda. Majelis jemaat akan mendoakan secara pribadi.</p>
        </div>
        <a href="/persembahan#form" class="btn-a">Kirim permohonan doa</a>
    </div>
</section>
@endsection
