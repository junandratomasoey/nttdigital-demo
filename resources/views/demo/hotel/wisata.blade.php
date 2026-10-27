@extends('demo.layout')
@section('judul', 'Wisata Sekitar')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Wisata Sekitar', 'sub' => 'Resepsionis kami siap membantu mengatur transportasi dan pemandu lokal.'])
<section>
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-14 sm:px-6 md:grid-cols-2">
        @foreach($demo->itemsTipe('wisata') as $w)
        <article class="overflow-hidden rounded-2xl border border-stone-200">
            <x-gambar :src="$w->gambar" :label="$w->nama" :warna="$w->d('warna')" class="aspect-[16/9]" />
            <div class="p-6">
                <div class="text-xs font-semibold uppercase tracking-wider text-c">{{ $w->subjudul }}</div>
                <h2 class="mt-1 font-display text-2xl font-medium text-stone-900">{{ $w->nama }}</h2>
                <p class="mt-2 font-light text-stone-600">{{ $w->deskripsi }}</p>
            </div>
        </article>
        @endforeach
    </div>
</section>
@endsection
