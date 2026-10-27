@extends('demo.layout')
@section('judul', 'Galeri')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Galeri', 'sub' => 'Dokumentasi kegiatan ' . $demo->nama . '.'])
<section x-data="{ lihat: null }">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
            @foreach($demo->itemsTipe('galeri') as $g)
            <figure class="overflow-hidden rounded-2xl bg-stone-100">
                <button type="button" class="block w-full" @click="lihat = @js($g->nama)">
                    <x-gambar :src="$g->gambar" :label="$g->nama" :warna="$g->d('warna')" class="aspect-[4/3]" />
                </button>
                <figcaption class="p-3 text-sm text-stone-600">{{ $g->nama }}</figcaption>
            </figure>
            @endforeach
        </div>
    </div>
</section>
@endsection
