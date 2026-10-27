@extends('demo.layout')
@section('konten')
@php
    $produk = $demo->itemsTipe('produk');
    $unggulan = $produk->where('data.unggulan', true)->take(3);
    $keunggulan = $demo->itemsTipe('keunggulan');
@endphp

<section class="bg-[#FBF6EE]">
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-14 sm:px-6 md:py-20 lg:grid-cols-2">
        <div>
            <p class="label-seksi">{{ $demo->d('sub_nama') }}</p>
            <h1 class="mt-4 font-display text-5xl leading-[1.02] text-stone-900 md:text-7xl">{{ $demo->hero_judul }}</h1>
            <p class="mt-6 max-w-md text-lg text-stone-600">{{ $demo->hero_sub }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="/produk" class="btn-c">Lihat koleksi</a>
                <a href="{{ $demo->linkWa('Halo ' . $demo->nama . ', saya ingin tanya koleksi tenun.') }}" target="_blank" rel="noopener" class="btn-garis text-c">Tanya via WhatsApp</a>
            </div>
        </div>
        <div class="grid grid-cols-5 grid-rows-5 gap-3" style="height: 460px;">
            @foreach($unggulan->values() as $i => $p)
            <a href="/produk/{{ $p->slug }}" class="{{ ['col-span-3 row-span-5', 'col-span-2 row-span-3', 'col-span-2 row-span-2'][$i] }} overflow-hidden rounded-xl">
                <x-gambar :src="$p->gambar" :label="$p->nama" :warna="$p->d('warna')" class="h-full" />
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="border-y border-stone-200">
    <div class="mx-auto grid max-w-6xl gap-px bg-stone-200 sm:grid-cols-3">
        @foreach($keunggulan as $k)
        <div class="bg-white p-6">
            <div class="font-display text-xl text-stone-900">{{ $k->nama }}</div>
            <p class="mt-2 text-sm text-stone-600">{{ $k->deskripsi }}</p>
        </div>
        @endforeach
    </div>
</section>

<section>
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <h2 class="font-display text-4xl text-stone-900">Koleksi terbaru</h2>
            <a href="/produk" class="text-sm font-bold text-c hover:underline">Semua produk →</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-x-5 gap-y-8 md:grid-cols-4">
            @foreach($produk->take(8) as $p)
                @include('demo.umkm.kartu-produk')
            @endforeach
        </div>
    </div>
</section>

<section class="motif bg-c text-white">
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-16 sm:px-6 md:grid-cols-2">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-a">Cerita kami</p>
            <h2 class="mt-3 font-display text-4xl">{{ $demo->d('cerita_judul') }}</h2>
        </div>
        <div>
            <p class="leading-relaxed text-white/85">{{ $demo->deskripsi }}</p>
            <a href="/profil" class="btn-a mt-6">Kenali penenun kami</a>
        </div>
    </div>
</section>

@if($posts->isNotEmpty())
<section class="bg-[#FBF6EE]">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <h2 class="font-display text-4xl text-stone-900">Dari bengkel tenun</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach($posts as $post) @include('demo.shared.kartu-post') @endforeach
        </div>
    </div>
</section>
@endif
@endsection
