@extends('demo.layout')
@section('body-class', 'bg-[#1F1B17] text-[#EFE6D8]')
@section('konten')
@php
    $p = $demo->d('pria'); $w = $demo->d('wanita');
    $tgl = \Illuminate\Support\Carbon::parse($demo->d('tanggal'));
    $acara = $demo->itemsTipe('acara');
    $kisah = $demo->itemsTipe('kisah');
    $galeri = $demo->itemsTipe('galeri');
    $hadiah = $demo->itemsTipe('hadiah');
    $emas = 'text-a';
@endphp

<div x-data="{ buka: {{ session('terkirim') || $errors->any() ? 'true' : 'false' }} }" class="text-lg">

    {{-- SAMPUL --}}
    <section x-show="!buka" x-transition.opacity.duration.500ms
             class="motif fixed inset-0 z-40 flex items-center justify-center bg-[#1F1B17] px-6 text-center">
        <div>
            <p class="text-sm uppercase tracking-[0.35em] text-[#EFE6D8]/70">Undangan Pernikahan</p>
            <h1 class="mt-6 font-display text-6xl leading-tight {{ $emas }} md:text-8xl">{{ $p['panggilan'] }} <span class="text-4xl md:text-6xl">&amp;</span> {{ $w['panggilan'] }}</h1>
            <p class="mt-4 tracking-widest">{{ $tgl->translatedFormat('d . m . Y') }}</p>
            <div class="mx-auto mt-10 max-w-xs border-y border-[#EFE6D8]/20 py-5">
                <p class="text-sm text-[#EFE6D8]/70">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                <p class="mt-1 text-2xl font-semibold">{{ $tamu ?: 'Tamu Undangan' }}</p>
            </div>
            <button type="button" @click="buka = true; window.scrollTo(0, 0)" class="btn-a mt-8 px-8">Buka Undangan</button>
            <p class="mt-6 text-xs text-[#EFE6D8]/50">Tips demo: tambahkan <code>?to=Nama+Tamu</code> di alamat untuk nama tamu personal.</p>
        </div>
    </section>

    {{-- PEMBUKA --}}
    <section class="motif flex min-h-[90vh] items-center justify-center px-6 py-24 text-center">
        <div class="max-w-2xl">
            <p class="text-sm uppercase tracking-[0.35em] text-[#EFE6D8]/70">The Wedding of</p>
            <h2 class="mt-6 font-display text-7xl leading-tight {{ $emas }} md:text-9xl">{{ $p['panggilan'] }} &amp; {{ $w['panggilan'] }}</h2>
            <p class="mx-auto mt-8 max-w-lg italic text-[#EFE6D8]/80">“{{ $demo->d('ayat.teks') }}”</p>
            <p class="mt-2 text-sm tracking-widest {{ $emas }}">{{ $demo->d('ayat.sumber') }}</p>
        </div>
    </section>

    {{-- MEMPELAI --}}
    <section class="bg-[#EFE6D8] px-6 py-24 text-[#2B2620]">
        <div class="mx-auto max-w-4xl text-center">
            <p class="text-base italic">{{ $demo->d('salam') }}</p>
            <div class="mt-14 grid items-center gap-12 md:grid-cols-[1fr_auto_1fr]">
                @foreach([$p, null, $w] as $orang)
                    @if($orang)
                    <div>
                        <x-gambar :src="null" :label="$orang['panggilan']" class="mx-auto aspect-square w-44 rounded-full" />
                        <h3 class="mt-6 font-display text-5xl text-c">{{ $orang['nama'] }}</h3>
                        <p class="mt-3 text-base">{{ $orang['anak'] }}</p>
                        <p class="text-base font-semibold">{{ $orang['ortu'] }}</p>
                    </div>
                    @else
                    <div class="font-display text-6xl text-a">&amp;</div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    {{-- HITUNG MUNDUR --}}
    <section class="motif px-6 py-24 text-center"
             x-data="{ t: {{ $tgl->timestamp * 1000 }}, s: {h:0,j:0,m:0,d:0},
                       tick() { let x = Math.max(0, this.t - Date.now()) / 1000; this.s = { h: Math.floor(x/86400), j: Math.floor(x%86400/3600), m: Math.floor(x%3600/60), d: Math.floor(x%60) } } }"
             x-init="tick(); setInterval(() => tick(), 1000)">
        <p class="text-sm uppercase tracking-[0.35em] text-[#EFE6D8]/70">Menuju hari bahagia</p>
        <p class="mt-4 font-display text-5xl {{ $emas }}">{{ $tgl->translatedFormat('l, d F Y') }}</p>
        <div class="mx-auto mt-10 grid max-w-md grid-cols-4 gap-3">
            @foreach(['h' => 'Hari', 'j' => 'Jam', 'm' => 'Menit', 'd' => 'Detik'] as $k => $l)
            <div class="rounded-xl border border-[#EFE6D8]/20 py-4">
                <div class="text-4xl font-semibold tabular-nums" x-text="s.{{ $k }}">0</div>
                <div class="text-xs uppercase tracking-wider text-[#EFE6D8]/60">{{ $l }}</div>
            </div>
            @endforeach
        </div>
        <a target="_blank" rel="noopener" class="btn-garis mt-10 text-a"
           href="https://calendar.google.com/calendar/render?action=TEMPLATE&text={{ urlencode('Pernikahan ' . $p['panggilan'] . ' & ' . $w['panggilan']) }}&dates={{ $tgl->format('Ymd\THis') }}/{{ $tgl->copy()->addHours(6)->format('Ymd\THis') }}&ctz=Asia/Makassar">Simpan ke Google Calendar</a>
    </section>

    {{-- ACARA --}}
    <section class="bg-[#EFE6D8] px-6 py-24 text-[#2B2620]">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="font-display text-6xl text-c">Rangkaian Acara</h2>
            <div class="mt-12 grid gap-6 md:grid-cols-2">
                @foreach($acara as $a)
                <div class="rounded-3xl border border-[#2B2620]/15 bg-white/60 p-8">
                    <h3 class="font-display text-4xl text-c">{{ $a->nama }}</h3>
                    <p class="mt-4 font-semibold">{{ $tgl->translatedFormat('l, d F Y') }}</p>
                    <p>{{ $a->subjudul }}</p>
                    <p class="mt-4 font-semibold">{{ $a->d('tempat') }}</p>
                    <p class="text-base">{{ $a->deskripsi }}</p>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($a->d('tempat') . ' ' . $a->deskripsi) }}" target="_blank" rel="noopener" class="btn-c mt-6">Lihat lokasi</a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- KISAH --}}
    <section class="motif px-6 py-24">
        <div class="mx-auto max-w-2xl">
            <h2 class="text-center font-display text-6xl {{ $emas }}">Kisah Kami</h2>
            <ol class="relative mt-12 space-y-10 border-l border-[#EFE6D8]/25 pl-8">
                @foreach($kisah as $k)
                <li>
                    <span class="absolute -left-[7px] mt-2 h-3.5 w-3.5 rounded-full bg-a"></span>
                    <div class="text-sm uppercase tracking-widest text-a">{{ $k->subjudul }}</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $k->nama }}</div>
                    <p class="mt-2 text-[#EFE6D8]/80">{{ $k->deskripsi }}</p>
                </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- GALERI --}}
    <section class="bg-[#EFE6D8] px-6 py-24 text-[#2B2620]">
        <div class="mx-auto max-w-5xl">
            <h2 class="text-center font-display text-6xl text-c">Galeri</h2>
            <div class="mt-12 grid grid-cols-2 gap-3 md:grid-cols-3">
                @foreach($galeri as $g)
                <x-gambar :src="$g->gambar" :label="$g->nama" :warna="$g->d('warna')" class="{{ $loop->first ? 'row-span-2 h-full' : 'aspect-square' }} rounded-2xl" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- AMPLOP --}}
    <section class="motif px-6 py-24 text-center">
        <div class="mx-auto max-w-2xl">
            <h2 class="font-display text-6xl {{ $emas }}">Amplop Digital</h2>
            <p class="mt-4 text-[#EFE6D8]/80">Doa restu Anda adalah hadiah terindah. Bila ingin memberi tanda kasih, dapat melalui:</p>
            <div class="mt-10 grid gap-4 sm:grid-cols-2">
                @foreach($hadiah as $h)
                <div class="rounded-2xl border border-[#EFE6D8]/20 p-6" x-data="{ ok: false }">
                    <div class="text-sm uppercase tracking-widest text-a">{{ $h->nama }}</div>
                    <div class="mt-2 font-mono text-xl tracking-wider">{{ $h->d('nomor') }}</div>
                    <div class="text-base text-[#EFE6D8]/70">a.n. {{ $h->d('atas_nama') }}</div>
                    <button type="button" class="mt-4 rounded-full border border-[#EFE6D8]/30 px-4 py-1.5 text-sm"
                            @click="navigator.clipboard?.writeText(@js($h->d('nomor'))); ok = true; setTimeout(() => ok = false, 1500)" x-text="ok ? 'Tersalin' : 'Salin nomor'">Salin nomor</button>
                </div>
                @endforeach
            </div>
            <p class="mt-4 text-xs text-[#EFE6D8]/50">Nomor rekening pada demo ini fiktif.</p>
        </div>
    </section>

    {{-- RSVP & UCAPAN --}}
    <section class="bg-[#EFE6D8] px-6 py-24 text-[#2B2620]">
        <div class="mx-auto grid max-w-5xl gap-10 md:grid-cols-2">
            <div>
                <h2 class="font-display text-6xl text-c">RSVP</h2>
                <p class="mb-6 mt-2 text-base">Mohon konfirmasi kehadiran Anda.</p>
                <x-form-kiriman tipe="rsvp" tombol="Kirim Konfirmasi" label-kontak="Nomor HP (opsional)"
                    pesan-sukses="Terima kasih atas konfirmasi dan doa restunya!"
                    :kolom="[
                        ['data.kehadiran', 'Kehadiran', 'select', true, ['Hadir', 'Masih ragu', 'Tidak bisa hadir']],
                        ['data.jumlah', 'Jumlah orang', 'number'],
                        ['data.ucapan', 'Ucapan & doa', 'textarea', true],
                    ]" />
            </div>
            <div>
                <h2 class="font-display text-6xl text-c">Ucapan</h2>
                <p class="mb-6 mt-2 text-base">{{ $ucapan->count() }} ucapan</p>
                <div class="max-h-[520px] space-y-3 overflow-y-auto pr-2">
                    @foreach($ucapan as $u)
                    <div class="rounded-2xl bg-white/70 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <span class="font-semibold">{{ $u->nama }}</span>
                            <span class="rounded-full bg-c px-2 py-0.5 text-xs text-white">{{ $u->data['kehadiran'] ?? '' }}</span>
                        </div>
                        <p class="mt-1 text-base text-[#2B2620]/80">{{ $u->data['ucapan'] ?? '' }}</p>
                        <p class="mt-1 text-xs text-[#2B2620]/50">{{ $u->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <footer class="motif px-6 py-16 text-center">
        <p class="font-display text-5xl {{ $emas }}">{{ $p['panggilan'] }} &amp; {{ $w['panggilan'] }}</p>
        <p class="mt-4 text-sm text-[#EFE6D8]/60">Terima kasih atas doa dan kehadiran Anda.</p>
        <p class="mt-8 text-xs text-[#EFE6D8]/40">Undangan digital oleh <a href="{{ config('demo.situs_utama') }}" class="underline">NTT Digital</a> · Nama &amp; data fiktif</p>
    </footer>
</div>
@endsection
