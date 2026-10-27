@extends('demo.layout')
@section('judul', $item->nama)
@section('konten')
<section>
    <x-gambar :src="$item->gambar" :label="$item->nama" :warna="$item->d('warna')" class="h-[420px]" />
</section>
<section>
    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-14 sm:px-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <a href="/kamar" class="text-sm text-stone-500 hover:text-c">← Semua kamar</a>
            <h1 class="mt-4 font-display text-5xl font-medium text-stone-900">{{ $item->nama }}</h1>
            <p class="mt-2 font-light text-stone-500">{{ $item->subjudul }}</p>
            <p class="mt-6 text-lg font-light leading-relaxed text-stone-700">{{ $item->deskripsi }}</p>
            <h2 class="mt-10 font-display text-2xl font-medium">Fasilitas kamar</h2>
            <ul class="mt-4 grid grid-cols-2 gap-3 text-stone-700">
                @foreach($item->d('fasilitas', []) as $f)<li class="flex items-center gap-2"><span class="text-c">✓</span> {{ $f }}</li>@endforeach
            </ul>
        </div>
        <aside class="h-fit rounded-2xl border border-stone-200 p-6 lg:sticky lg:top-24">
            <div class="text-sm text-stone-500">Mulai dari</div>
            <div class="font-display text-3xl font-medium text-c">{{ $item->harga_rp }}</div>
            <div class="text-sm text-stone-500">per malam, termasuk sarapan</div>
            <dl class="mt-5 space-y-2 border-t border-stone-200 pt-5 text-sm">
                <div class="flex justify-between"><dt class="text-stone-500">Kapasitas</dt><dd>{{ $item->d('kapasitas') }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Ukuran</dt><dd>{{ $item->d('ukuran') }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-500">Ranjang</dt><dd>{{ $item->d('ranjang') }}</dd></div>
            </dl>
            <a href="/reservasi?kamar={{ urlencode($item->nama) }}#form" class="btn-c mt-6 w-full">Pesan kamar ini</a>
            <a href="{{ $demo->linkWa('Halo ' . $demo->nama . ', saya ingin tanya ketersediaan ' . $item->nama . '.') }}" target="_blank" rel="noopener" class="mt-2 flex w-full justify-center rounded-full border border-emerald-600 py-2.5 text-sm font-semibold text-emerald-700">Tanya via WhatsApp</a>
        </aside>
    </div>
</section>
@endsection
