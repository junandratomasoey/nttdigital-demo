@extends('demo.layout')
@section('judul', $item->nama)
@section('konten')
<section x-data="{ jumlah: 1 }">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-2">
        <x-gambar :src="$item->gambar" :label="$item->nama" :warna="$item->d('warna')" class="aspect-[4/5] rounded-2xl" />
        <div class="md:py-6">
            <a href="/produk" class="text-sm text-stone-500 hover:text-c">← Koleksi</a>
            <p class="mt-6 text-xs uppercase tracking-[0.2em] text-stone-500">{{ $item->subjudul }}</p>
            <h1 class="mt-2 font-display text-4xl text-stone-900 md:text-5xl">{{ $item->nama }}</h1>
            <div class="mt-4 text-2xl font-bold text-c">{{ $item->harga_rp }}</div>
            <p class="mt-6 leading-relaxed text-stone-700">{{ $item->deskripsi }}</p>
            <dl class="mt-6 grid grid-cols-2 gap-4 border-y border-stone-200 py-5 text-sm">
                @foreach(['ukuran' => 'Ukuran', 'bahan' => 'Bahan', 'asal' => 'Asal motif', 'pengerjaan' => 'Pengerjaan'] as $k => $l)
                    @if($item->d($k))<div><dt class="text-stone-500">{{ $l }}</dt><dd class="font-medium text-stone-900">{{ $item->d($k) }}</dd></div>@endif
                @endforeach
            </dl>
            <div class="mt-6 flex items-center gap-4">
                <label for="jumlah" class="text-sm text-stone-600">Jumlah</label>
                <div class="flex items-center rounded-full border border-stone-300">
                    <button type="button" class="px-4 py-2" @click="jumlah = Math.max(1, jumlah - 1)" aria-label="Kurangi">−</button>
                    <input id="jumlah" type="number" min="1" x-model.number="jumlah" class="w-12 border-0 text-center focus:ring-0">
                    <button type="button" class="px-4 py-2" @click="jumlah++" aria-label="Tambah">+</button>
                </div>
            </div>
            <a :href="'https://wa.me/' + @js($demo->whatsapp ?: config('demo.whatsapp')) + '?text=' + encodeURIComponent(@js('Halo ' . $demo->nama . ', saya ingin memesan ') + jumlah + @js(' x ' . $item->nama . ' (' . $item->harga_rp . ').'))"
               target="_blank" rel="noopener"
               class="mt-6 flex w-full items-center justify-center gap-2 rounded-full bg-emerald-600 py-3.5 font-semibold text-white hover:bg-emerald-500 sm:w-auto sm:px-10">
                Pesan via WhatsApp
            </a>
            <p class="mt-3 text-xs text-stone-500">Pembayaran & ongkir dikonfirmasi lewat chat. Pengiriman ke seluruh Indonesia.</p>
        </div>
    </div>
</section>
@if($lain->isNotEmpty())
<section class="bg-[#FBF6EE]"><div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
    <h2 class="mb-8 font-display text-3xl text-stone-900">Mungkin Anda suka</h2>
    <div class="grid grid-cols-2 gap-5 md:grid-cols-3">
        @foreach($lain as $p) @include('demo.umkm.kartu-produk') @endforeach
    </div>
</div></section>
@endif
@endsection
