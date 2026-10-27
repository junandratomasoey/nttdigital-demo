@extends('demo.layout')
@section('judul', 'Layanan Surat')
@section('konten')
@php $surat = $demo->itemsTipe('surat'); @endphp
@include('demo.shared.kepala', ['judul' => 'Layanan Surat Online', 'sub' => 'Ajukan permohonan dari rumah. Petugas akan menghubungi Anda saat surat siap diambil.'])
<section>
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-5">
        <div class="space-y-4 lg:col-span-2">
            <h2 class="font-display text-2xl font-bold text-stone-900">Jenis surat & persyaratan</h2>
            @foreach($surat as $s)
            <details class="group rounded-2xl border border-stone-200 p-5 open:border-c open:bg-c-soft" @if($loop->first) open @endif>
                <summary class="flex cursor-pointer list-none items-center justify-between gap-3 font-semibold text-stone-900">
                    <span><span aria-hidden="true">{{ $s->ikon }}</span> {{ $s->nama }}</span>
                    <span class="text-xs font-normal text-stone-500">{{ $s->d('lama') }}</span>
                </summary>
                <p class="mt-3 text-sm text-stone-600">{{ $s->deskripsi }}</p>
                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-stone-700">
                    @foreach($s->d('syarat', []) as $syarat)<li>{{ $syarat }}</li>@endforeach
                </ul>
            </details>
            @endforeach
        </div>
        <div class="rounded-2xl bg-stone-50 p-6 sm:p-8 lg:col-span-3">
            <h2 class="mb-6 font-display text-2xl font-bold text-stone-900">Formulir permohonan</h2>
            <x-form-kiriman tipe="surat" tombol="Ajukan Permohonan"
                pesan-sukses="Permohonan surat Anda tercatat. Petugas akan menghubungi lewat WhatsApp saat surat siap diambil di kantor desa."
                :kolom="[
                    ['data.jenis_surat', 'Jenis surat', 'select', true, $surat->pluck('nama')->all(), 'sm:col-span-2', 'jenis'],
                    ['data.nik', 'NIK', 'text', true],
                    ['data.dusun', 'Dusun / RT', 'text', true],
                    ['data.keperluan', 'Keperluan', 'textarea', true],
                ]" />
        </div>
    </div>
</section>
@endsection
