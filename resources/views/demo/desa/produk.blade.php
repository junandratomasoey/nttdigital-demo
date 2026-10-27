@extends('demo.layout')
@section('judul', 'Produk Desa')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Produk Desa', 'sub' => 'Hasil BUMDes dan UMKM warga. Pesan langsung lewat WhatsApp.'])
<section class="bg-stone-50">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <div class="grid grid-cols-2 gap-5 lg:grid-cols-4">
            @foreach($demo->itemsTipe('produk') as $p)
            <article class="flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white">
                <a href="/produk/{{ $p->slug }}"><x-gambar :src="$p->gambar" :label="$p->nama" :warna="$p->d('warna')" class="aspect-square" /></a>
                <div class="flex flex-1 flex-col p-4">
                    <h2 class="font-semibold text-stone-900"><a href="/produk/{{ $p->slug }}" class="hover:text-c">{{ $p->nama }}</a></h2>
                    <p class="mt-1 text-xs text-stone-500">{{ $p->subjudul }}</p>
                    <div class="mt-auto pt-3 text-sm font-bold text-c">{{ $p->harga_rp }} <span class="font-normal text-stone-500">/ {{ $p->d('satuan') }}</span></div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
