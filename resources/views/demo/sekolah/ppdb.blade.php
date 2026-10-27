@extends('demo.layout')
@section('judul', 'PPDB Online')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'PPDB Online ' . (now()->year + 1) . '/' . (now()->year + 2), 'sub' => 'Penerimaan Peserta Didik Baru. Isi formulir, panitia akan menghubungi Anda untuk verifikasi berkas.'])
<section>
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-5">
        <div class="space-y-6 lg:col-span-2">
            <div>
                <h2 class="font-display text-2xl font-bold text-stone-900">Jadwal</h2>
                <ol class="mt-4 space-y-3">
                    @foreach($demo->d('ppdb.jadwal', []) as [$tahap, $tgl])
                    <li class="flex gap-4 rounded-2xl border border-stone-200 p-4">
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-c font-bold text-white">{{ $loop->iteration }}</span>
                        <span><span class="block font-semibold text-stone-900">{{ $tahap }}</span><span class="text-sm text-stone-500">{{ $tgl }}</span></span>
                    </li>
                    @endforeach
                </ol>
            </div>
            <div class="rounded-2xl bg-a-soft p-5">
                <h3 class="font-bold text-stone-900">Berkas yang disiapkan</h3>
                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-stone-700">
                    @foreach($demo->d('ppdb.berkas', []) as $b)<li>{{ $b }}</li>@endforeach
                </ul>
            </div>
        </div>
        <div class="rounded-3xl bg-stone-50 p-6 sm:p-8 lg:col-span-3">
            <h2 class="mb-6 font-display text-2xl font-bold text-stone-900">Formulir pendaftaran</h2>
            <x-form-kiriman tipe="ppdb" tombol="Kirim Pendaftaran" label-kontak="Nomor HP orang tua / wali"
                pesan-sukses="Pendaftaran tersimpan. Panitia PPDB akan menghubungi orang tua/wali untuk jadwal verifikasi berkas."
                :kolom="[
                    ['data.nisn', 'NISN', 'text', true],
                    ['data.tanggal_lahir', 'Tanggal lahir', 'date', true],
                    ['data.asal_sekolah', 'Asal sekolah', 'text', true],
                    ['data.jalur', 'Jalur pendaftaran', 'select', true, ['Zonasi', 'Prestasi', 'Afirmasi', 'Perpindahan orang tua']],
                    ['data.nama_ortu', 'Nama orang tua / wali', 'text', true, [], 'sm:col-span-2'],
                    ['data.catatan', 'Catatan (opsional)', 'textarea'],
                ]" />
        </div>
    </div>
</section>
@endsection
