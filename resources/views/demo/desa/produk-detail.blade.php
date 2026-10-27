@extends('demo.layout')
@section('judul', $item->nama)
@section('konten')
<section>
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-2">
        <x-gambar :src="$item->gambar" :label="$item->nama" :warna="$item->d('warna')" class="aspect-square rounded-3xl" />
        <div>
            <nav class="mb-4 text-sm text-stone-500"><a href="/produk" class="hover:text-c">← Semua produk</a></nav>
            <p class="label-seksi">{{ $item->subjudul }}</p>
            <h1 class="mt-2 font-display text-4xl font-bold text-stone-900">{{ $item->nama }}</h1>
            <div class="mt-4 text-2xl font-bold text-c">{{ $item->harga_rp }} <span class="text-base font-normal text-stone-500">/ {{ $item->d('satuan') }}</span></div>
            <p class="mt-6 leading-relaxed text-stone-700">{{ $item->deskripsi }}</p>
            @if($item->d('produsen'))<p class="mt-4 text-sm text-stone-500">Produsen: {{ $item->d('produsen') }}</p>@endif
            <a href="{{ $demo->linkWa('Halo, saya ingin memesan ' . $item->nama . ' dari ' . $demo->nama . '.') }}" target="_blank" rel="noopener"
               class="mt-8 inline-flex items-center gap-2 rounded-full bg-emerald-600 px-6 py-3 font-semibold text-white hover:bg-emerald-500">Pesan via WhatsApp</a>
        </div>
    </div>
</section>
@if($lain->isNotEmpty())
<section class="bg-stone-50"><div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
    <h2 class="mb-6 font-display text-2xl font-bold">Produk lainnya</h2>
    <div class="grid grid-cols-2 gap-5 md:grid-cols-3">
        @foreach($lain as $p)
        <a href="/{{ request()->segment(1) }}/{{ $p->slug }}" class="overflow-hidden rounded-2xl border border-stone-200 bg-white">
            <x-gambar :src="$p->gambar" :label="$p->nama" :warna="$p->d('warna')" class="aspect-[4/3]" />
            <div class="p-4 font-semibold">{{ $p->nama }}<div class="text-sm text-c">{{ $p->harga_rp }}</div></div>
        </a>
        @endforeach
    </div>
</div></section>
@endif
@endsection
