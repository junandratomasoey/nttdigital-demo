@extends('demo.layout')
@section('konten')
@php
    $statistik = $demo->itemsTipe('statistik');
    $surat = $demo->itemsTipe('surat');
    $produk = $demo->itemsTipe('produk')->take(4);
    $apb = $demo->itemsTipe('apbdes');
    $pendapatan = $apb->where('data.jenis', 'pendapatan')->sum('harga');
    $belanja = $apb->where('data.jenis', 'belanja');
@endphp

{{-- HERO --}}
<section class="motif bg-c text-white">
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-14 sm:px-6 md:py-20 lg:grid-cols-5">
        <div class="lg:col-span-3">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-a">Website Resmi Pemerintah Desa</p>
            <h1 class="mt-3 font-display text-4xl font-bold leading-tight md:text-6xl">{{ $demo->hero_judul }}</h1>
            <p class="mt-5 max-w-xl text-lg text-white/80">{{ $demo->hero_sub }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="/layanan-surat" class="btn-a">Ajukan Surat Online</a>
                <a href="/apbdes" class="btn-garis text-white">Lihat APBDes {{ now()->year }}</a>
            </div>
        </div>
        <figure class="rounded-2xl bg-white p-6 text-stone-800 shadow-xl lg:col-span-2">
            <div class="flex items-center gap-4">
                <x-gambar :src="null" label="Kepala Desa" class="h-16 w-16 shrink-0 rounded-full" ikon="👤" />
                <div>
                    <div class="font-display text-lg font-bold">{{ $demo->d('kepala.nama') }}</div>
                    <div class="text-sm text-c">Kepala Desa {{ $demo->d('nama_pendek') }}</div>
                </div>
            </div>
            <blockquote class="mt-4 text-sm leading-relaxed text-stone-600">“{{ $demo->d('kepala.sambutan') }}”</blockquote>
            <a href="/profil" class="mt-4 inline-block text-sm font-semibold text-c hover:underline">Profil desa →</a>
        </figure>
    </div>
</section>

{{-- STATISTIK --}}
<section class="border-b border-stone-200 bg-white">
    <dl class="mx-auto grid max-w-6xl grid-cols-2 divide-stone-200 px-4 sm:px-6 md:grid-cols-4 md:divide-x">
        @foreach($statistik as $s)
        <div class="px-4 py-6 text-center">
            <dt class="text-xs font-semibold uppercase tracking-wider text-stone-500">{{ $s->nama }}</dt>
            <dd class="mt-1 font-display text-3xl font-bold text-c">{{ $s->subjudul }}</dd>
        </div>
        @endforeach
    </dl>
</section>

{{-- LAYANAN SURAT --}}
<section class="bg-c-soft">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="label-seksi">Layanan Administrasi</p>
                <h2 class="judul-seksi mt-2">Urus surat tanpa antre</h2>
            </div>
            <a href="/layanan-surat" class="text-sm font-semibold text-c hover:underline">Semua layanan →</a>
        </div>
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($surat->take(4) as $s)
            <a href="/layanan-surat?jenis={{ urlencode($s->nama) }}#form" class="rounded-2xl border border-stone-200 bg-white p-5 transition hover:border-c hover:shadow-md">
                <div class="text-2xl" aria-hidden="true">{{ $s->ikon }}</div>
                <div class="mt-3 font-semibold text-stone-900">{{ $s->nama }}</div>
                <div class="mt-1 text-sm text-stone-500">Selesai {{ $s->d('lama') }}</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- BERITA --}}
<section>
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div><p class="label-seksi">Kabar Desa</p><h2 class="judul-seksi mt-2">Berita terbaru</h2></div>
            <a href="/berita" class="text-sm font-semibold text-c hover:underline">Semua berita →</a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach($posts as $post) @include('demo.shared.kartu-post') @endforeach
        </div>
    </div>
</section>

{{-- APBDES RINGKAS --}}
<section class="bg-stone-50">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2">
        <div>
            <p class="label-seksi">Transparansi</p>
            <h2 class="judul-seksi mt-2">APBDes {{ now()->year }}</h2>
            <p class="mt-3 text-stone-600">Setiap rupiah Dana Desa dapat dipantau warga. Data diperbarui oleh operator desa setiap triwulan.</p>
            <div class="mt-6 rounded-2xl bg-c p-6 text-white">
                <div class="text-sm text-white/75">Total pendapatan desa</div>
                <div class="mt-1 font-display text-3xl font-bold tabular-nums">{{ \App\Support\Tema::rupiah($pendapatan) }}</div>
            </div>
            <a href="/apbdes" class="btn-c mt-6">Rincian lengkap</a>
        </div>
        <div class="space-y-4 rounded-2xl border border-stone-200 bg-white p-6">
            <div class="text-sm font-semibold text-stone-900">Belanja per bidang · realisasi</div>
            @foreach($belanja as $b)
            @php $persen = $b->harga ? min(100, round($b->d('realisasi', 0) / $b->harga * 100)) : 0; @endphp
            <div>
                <div class="flex justify-between gap-4 text-sm"><span class="text-stone-700">{{ $b->nama }}</span><span class="tabular-nums text-stone-500">{{ $persen }}%</span></div>
                <div class="mt-1.5 h-2.5 overflow-hidden rounded-full bg-stone-100"><div class="h-full rounded-full bg-c" style="width: {{ $persen }}%"></div></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PRODUK DESA --}}
<section>
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div><p class="label-seksi">BUMDes & UMKM</p><h2 class="judul-seksi mt-2">Produk unggulan desa</h2></div>
            <a href="/produk" class="text-sm font-semibold text-c hover:underline">Semua produk →</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-5 lg:grid-cols-4">
            @foreach($produk as $p)
            <a href="/produk/{{ $p->slug }}" class="group overflow-hidden rounded-2xl border border-stone-200 bg-white">
                <x-gambar :src="$p->gambar" :label="$p->nama" :warna="$p->d('warna')" class="aspect-square" />
                <div class="p-4">
                    <div class="font-semibold text-stone-900 group-hover:text-c">{{ $p->nama }}</div>
                    <div class="mt-1 text-sm font-semibold text-c">{{ $p->harga_rp }} <span class="font-normal text-stone-500">/ {{ $p->d('satuan') }}</span></div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ASPIRASI --}}
<section class="motif bg-c-deep text-white">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-14 sm:px-6 md:grid-cols-2 md:items-center">
        <div>
            <h2 class="font-display text-3xl font-bold">Punya usulan untuk desa?</h2>
            <p class="mt-3 text-white/75">Sampaikan aspirasi, saran, atau pengaduan. Pemerintah desa membaca setiap pesan yang masuk.</p>
        </div>
        <div class="md:text-right"><a href="/kontak" class="btn-a">Sampaikan aspirasi</a></div>
    </div>
</section>
@endsection
