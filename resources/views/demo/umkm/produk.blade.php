@extends('demo.layout')
@section('judul', 'Produk')
@section('konten')
@php $produk = $demo->itemsTipe('produk'); $kategori = $produk->pluck('subjudul')->unique()->values(); @endphp
<section class="bg-[#FBF6EE]">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <h1 class="font-display text-5xl text-stone-900">Koleksi</h1>
        <p class="mt-3 text-stone-600">Setiap kain ditenun tangan. Motif dan warna bisa sedikit berbeda dari foto — itulah keunikannya.</p>
    </div>
</section>
<section x-data="{ pilih: 'Semua' }">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6">
        <div class="mb-8 flex flex-wrap gap-2" role="group" aria-label="Filter kategori">
            @foreach($kategori->prepend('Semua') as $k)
            <button type="button" @click="pilih = @js($k)" :aria-pressed="pilih === @js($k)"
                    :class="pilih === @js($k) ? 'bg-c text-white border-transparent' : 'border-stone-300 text-stone-700 hover:border-stone-500'"
                    class="rounded-full border px-4 py-1.5 text-sm font-medium transition">{{ $k }}</button>
            @endforeach
        </div>
        <div class="grid grid-cols-2 gap-x-5 gap-y-8 md:grid-cols-3 lg:grid-cols-4">
            @foreach($produk as $p)
            <div x-show="pilih === 'Semua' || pilih === @js($p->subjudul)" x-transition.opacity>
                @include('demo.umkm.kartu-produk')
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
