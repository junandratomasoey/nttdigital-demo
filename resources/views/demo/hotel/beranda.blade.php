@extends('demo.layout')
@section('konten')
@php $kamar = $demo->itemsTipe('kamar'); $fasilitas = $demo->itemsTipe('fasilitas'); $wisata = $demo->itemsTipe('wisata'); @endphp

<section class="relative">
    <x-gambar :src="$demo->hero_gambar" label="" class="h-[560px] md:h-[640px]" />
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0">
        <div class="mx-auto max-w-6xl px-4 pb-10 text-white sm:px-6">
            <p class="text-sm uppercase tracking-[0.3em] text-white/80">{{ $demo->d('sub_nama') }}</p>
            <h1 class="mt-3 max-w-3xl font-display text-5xl font-medium leading-[1.05] md:text-7xl">{{ $demo->hero_judul }}</h1>
            <p class="mt-4 max-w-xl text-lg font-light text-white/85">{{ $demo->hero_sub }}</p>

            <form action="/reservasi" method="GET" class="mt-8 grid gap-3 rounded-2xl bg-white p-4 text-stone-800 shadow-2xl sm:grid-cols-2 lg:grid-cols-[1fr_1fr_1fr_auto]">
                <div><label for="cari-in" class="text-xs font-semibold uppercase tracking-wider text-stone-500">Check-in</label><input id="cari-in" type="date" name="masuk" class="input mt-1" min="{{ now()->toDateString() }}"></div>
                <div><label for="cari-out" class="text-xs font-semibold uppercase tracking-wider text-stone-500">Check-out</label><input id="cari-out" type="date" name="keluar" class="input mt-1" min="{{ now()->addDay()->toDateString() }}"></div>
                <div><label for="cari-kamar" class="text-xs font-semibold uppercase tracking-wider text-stone-500">Tipe kamar</label>
                    <select id="cari-kamar" name="kamar" class="input mt-1"><option value="">Semua tipe</option>@foreach($kamar as $k)<option>{{ $k->nama }}</option>@endforeach</select></div>
                <button class="btn-c self-end rounded-xl py-3">Cek ketersediaan</button>
            </form>
        </div>
    </div>
</section>

<section>
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-20 sm:px-6 md:grid-cols-2 md:items-center">
        <div>
            <p class="label-seksi">Selamat datang</p>
            <h2 class="mt-3 font-display text-4xl font-medium leading-tight text-stone-900">{{ $demo->d('sambutan_judul') }}</h2>
        </div>
        <p class="text-lg font-light leading-relaxed text-stone-600">{{ $demo->deskripsi }}</p>
    </div>
</section>

<section class="bg-[#F6F1E9]">
    <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <h2 class="font-display text-4xl font-medium text-stone-900">Kamar & suite</h2>
            <a href="/kamar" class="text-sm font-semibold text-c hover:underline">Lihat semua kamar →</a>
        </div>
        <div class="mt-10 grid gap-8 md:grid-cols-3">
            @foreach($kamar as $k) @include('demo.hotel.kartu-kamar') @endforeach
        </div>
    </div>
</section>

<section>
    <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6">
        <h2 class="text-center font-display text-4xl font-medium text-stone-900">Fasilitas</h2>
        <div class="mt-10 grid grid-cols-2 gap-6 md:grid-cols-4">
            @foreach($fasilitas->take(8) as $f)
            <div class="text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-c-soft text-2xl" aria-hidden="true">{{ $f->ikon }}</div>
                <div class="mt-3 font-medium text-stone-900">{{ $f->nama }}</div>
                <div class="text-sm font-light text-stone-500">{{ $f->subjudul }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="motif bg-c text-white">
    <div class="mx-auto max-w-6xl px-4 py-20 sm:px-6">
        <h2 class="font-display text-4xl font-medium">Jelajahi sekitar</h2>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach($wisata->take(3) as $w)
            <div class="overflow-hidden rounded-2xl bg-white/10">
                <x-gambar :src="$w->gambar" :label="$w->nama" :warna="$w->d('warna')" class="aspect-[4/3]" />
                <div class="p-5">
                    <div class="text-xs uppercase tracking-wider text-a">{{ $w->subjudul }}</div>
                    <div class="mt-1 font-display text-2xl">{{ $w->nama }}</div>
                    <p class="mt-2 text-sm font-light text-white/80">{{ $w->deskripsi }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
