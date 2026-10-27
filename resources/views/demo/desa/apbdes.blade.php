@extends('demo.layout')
@section('judul', 'APBDes')
@section('konten')
@php
    $apb = $demo->itemsTipe('apbdes');
    $pendapatan = $apb->where('data.jenis', 'pendapatan');
    $belanja = $apb->where('data.jenis', 'belanja');
    $rp = fn ($n) => \App\Support\Tema::rupiah($n);
@endphp
@include('demo.shared.kepala', ['judul' => 'APBDes ' . now()->year, 'sub' => 'Anggaran Pendapatan dan Belanja Desa beserta realisasinya, terbuka untuk seluruh warga.'])
<section>
    <div class="mx-auto max-w-6xl space-y-10 px-4 py-14 sm:px-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl bg-c p-6 text-white"><div class="text-sm text-white/75">Pendapatan</div><div class="mt-1 font-display text-2xl font-bold tabular-nums">{{ $rp($pendapatan->sum('harga')) }}</div></div>
            <div class="rounded-2xl bg-stone-900 p-6 text-white"><div class="text-sm text-white/70">Belanja</div><div class="mt-1 font-display text-2xl font-bold tabular-nums">{{ $rp($belanja->sum('harga')) }}</div></div>
            <div class="rounded-2xl border border-stone-200 p-6"><div class="text-sm text-stone-500">Realisasi belanja</div><div class="mt-1 font-display text-2xl font-bold tabular-nums text-c">{{ $rp($belanja->sum(fn ($b) => $b->d('realisasi'))) }}</div></div>
        </div>
        @foreach(['Pendapatan' => $pendapatan, 'Belanja' => $belanja] as $judul => $baris)
        <div>
            <h2 class="mb-4 font-display text-2xl font-bold text-stone-900">{{ $judul }}</h2>
            <div class="overflow-x-auto rounded-2xl border border-stone-200">
                <table class="w-full min-w-[560px] text-sm">
                    <thead class="bg-stone-50 text-left text-stone-500"><tr><th class="px-5 py-3 font-semibold">Uraian</th><th class="px-5 py-3 text-right font-semibold">Anggaran</th><th class="px-5 py-3 text-right font-semibold">Realisasi</th><th class="w-40 px-5 py-3 font-semibold">%</th></tr></thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($baris as $b)
                        @php $p = $b->harga ? min(100, round($b->d('realisasi', 0) / $b->harga * 100)) : 0; @endphp
                        <tr>
                            <td class="px-5 py-3 text-stone-800">{{ $b->nama }}<div class="text-xs text-stone-500">{{ $b->deskripsi }}</div></td>
                            <td class="px-5 py-3 text-right tabular-nums">{{ $rp($b->harga) }}</td>
                            <td class="px-5 py-3 text-right tabular-nums">{{ $rp($b->d('realisasi')) }}</td>
                            <td class="px-5 py-3"><div class="flex items-center gap-2"><div class="h-2 flex-1 overflow-hidden rounded-full bg-stone-100"><div class="h-full bg-c" style="width: {{ $p }}%"></div></div><span class="w-9 text-right tabular-nums text-stone-500">{{ $p }}%</span></div></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
        <p class="text-xs text-stone-500">Angka di halaman demo ini fiktif. Pada website asli, data diisi operator desa melalui panel admin.</p>
    </div>
</section>
@endsection
