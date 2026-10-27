@extends('demo.layout')
@section('konten')
@php
    $statistik = $demo->itemsTipe('statistik');
    $program = $demo->itemsTipe('program');
    $prestasi = $demo->itemsTipe('prestasi');
    $guru = $demo->itemsTipe('guru')->take(4);
@endphp

<section class="relative overflow-hidden bg-c text-white">
    <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-a opacity-90" aria-hidden="true"></div>
    <div class="absolute -bottom-32 right-40 h-64 w-64 rounded-full border-[28px] border-white/10" aria-hidden="true"></div>
    <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-2">
        <div>
            <span class="inline-block rounded-full bg-white/15 px-4 py-1.5 text-sm font-semibold">PPDB {{ now()->year + 1 }}/{{ now()->year + 2 }} dibuka</span>
            <h1 class="mt-4 font-display text-4xl font-extrabold leading-[1.05] md:text-6xl">{{ $demo->hero_judul }}</h1>
            <p class="mt-5 max-w-lg text-lg text-white/85">{{ $demo->hero_sub }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="/ppdb" class="btn-a">Daftar PPDB Online</a>
                <a href="/profil" class="btn-garis text-white">Kenali sekolah kami</a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @foreach($statistik as $s)
            <div class="rounded-3xl bg-white p-6 text-stone-900 shadow-xl {{ $loop->even ? 'translate-y-6' : '' }}">
                <div class="font-display text-4xl font-extrabold text-c">{{ $s->subjudul }}</div>
                <div class="mt-1 text-sm font-semibold text-stone-500">{{ $s->nama }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SAMBUTAN --}}
<section>
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-16 sm:px-6 md:grid-cols-3">
        <x-gambar :src="null" label="Kepala Sekolah" ikon="👩‍🏫" class="aspect-square rounded-[2rem]" />
        <div class="md:col-span-2">
            <p class="label-seksi">Sambutan Kepala Sekolah</p>
            <h2 class="judul-seksi mt-2">{{ $demo->d('kepala.judul') }}</h2>
            <p class="mt-4 leading-relaxed text-stone-600">{{ $demo->d('kepala.sambutan') }}</p>
            <p class="mt-4 font-display text-lg font-bold text-stone-900">{{ $demo->d('kepala.nama') }}</p>
            <p class="text-sm text-stone-500">Kepala {{ $demo->nama }}</p>
        </div>
    </div>
</section>

{{-- PROGRAM --}}
<section class="bg-a-soft">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <p class="label-seksi">Program Unggulan</p>
        <h2 class="judul-seksi mt-2">Belajar lebih dari sekadar di kelas</h2>
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($program as $p)
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="grid h-12 w-12 place-items-center rounded-2xl bg-c text-2xl text-white" aria-hidden="true">{{ $p->ikon }}</div>
                <h3 class="mt-4 font-display text-xl font-bold text-stone-900">{{ $p->nama }}</h3>
                <p class="mt-2 text-sm leading-relaxed text-stone-600">{{ $p->deskripsi }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PRESTASI + BERITA --}}
<section>
    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-3">
        <div>
            <p class="label-seksi">Prestasi</p>
            <h2 class="judul-seksi mt-2">Kebanggaan kami</h2>
            <ul class="mt-6 space-y-3">
                @foreach($prestasi as $p)
                <li class="flex gap-4 rounded-2xl border border-stone-200 p-4">
                    <span class="text-2xl" aria-hidden="true">{{ $p->ikon }}</span>
                    <span><span class="block font-semibold text-stone-900">{{ $p->nama }}</span><span class="text-sm text-stone-500">{{ $p->subjudul }}</span></span>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="lg:col-span-2">
            <div class="flex items-end justify-between gap-4">
                <div><p class="label-seksi">Berita</p><h2 class="judul-seksi mt-2">Kabar sekolah</h2></div>
                <a href="/berita" class="text-sm font-bold text-c hover:underline">Semua →</a>
            </div>
            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                @foreach($posts->take(2) as $post) @include('demo.shared.kartu-post') @endforeach
            </div>
        </div>
    </div>
</section>

{{-- GURU --}}
<section class="bg-stone-50">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="flex items-end justify-between gap-4">
            <div><p class="label-seksi">Pendidik</p><h2 class="judul-seksi mt-2">Guru kami</h2></div>
            <a href="/guru" class="text-sm font-bold text-c hover:underline">Semua guru →</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-5 md:grid-cols-4">
            @foreach($guru as $g)
            <div class="rounded-3xl bg-white p-5 text-center">
                <x-gambar :src="$g->gambar" :label="$g->nama" :ikon="$g->ikon" class="mx-auto aspect-square w-24 rounded-full" />
                <div class="mt-3 font-bold text-stone-900">{{ $g->nama }}</div>
                <div class="text-sm text-c">{{ $g->subjudul }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-a">
    <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-6 px-4 py-12 sm:px-6 md:flex-row md:items-center">
        <h2 class="font-display text-3xl font-extrabold text-stone-900">Siap bergabung bersama kami?</h2>
        <a href="/ppdb" class="btn-c">Daftar sekarang</a>
    </div>
</section>
@endsection
