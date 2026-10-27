@extends('demo.layout')
@section('judul', 'Reservasi')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Permintaan Reservasi', 'sub' => 'Kirim permintaan, tim kami akan mengonfirmasi ketersediaan dan harga dalam 1 jam pada jam kerja.'])
<section>
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-3">
        <div class="rounded-2xl bg-[#F6F1E9] p-6 sm:p-8 lg:col-span-2">
            <x-form-kiriman tipe="reservasi" tombol="Kirim Permintaan Reservasi" label-kontak="Nomor WhatsApp"
                pesan-sukses="Permintaan reservasi diterima. Tim kami akan mengonfirmasi lewat WhatsApp."
                :kolom="[
                    ['data.kamar', 'Tipe kamar', 'select', true, $demo->itemsTipe('kamar')->pluck('nama')->all(), 'sm:col-span-2', 'kamar'],
                    ['data.check_in', 'Check-in', 'date', true, [], 'sm:col-span-1', 'masuk'],
                    ['data.check_out', 'Check-out', 'date', true, [], 'sm:col-span-1', 'keluar'],
                    ['data.tamu', 'Jumlah tamu', 'number', true],
                    ['data.email', 'Email (opsional)', 'email'],
                    ['data.catatan', 'Permintaan khusus', 'textarea'],
                ]" />
        </div>
        <aside class="space-y-4 text-sm">
            <div class="rounded-2xl border border-stone-200 p-5"><div class="label-seksi">Check-in / out</div><p class="mt-1">{{ $demo->d('jam_checkin') }}</p></div>
            <div class="rounded-2xl border border-stone-200 p-5"><div class="label-seksi">Kebijakan pembatalan</div><p class="mt-1">{{ $demo->d('pembatalan') }}</p></div>
            <a href="{{ $demo->linkWa('Halo ' . $demo->nama . ', saya ingin reservasi kamar.') }}" target="_blank" rel="noopener" class="flex justify-center rounded-2xl bg-emerald-600 p-4 font-semibold text-white">Reservasi via WhatsApp</a>
        </aside>
    </div>
</section>
@endsection
