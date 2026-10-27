@extends('demo.layout')
@section('judul', 'Kontak')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Kontak', 'sub' => 'Hubungi kami untuk informasi, saran, atau pengaduan.'])
<section>
    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-14 sm:px-6 lg:grid-cols-5">
        <div class="space-y-4 lg:col-span-2">
            @foreach([['Alamat', $demo->alamat], ['Telepon', $demo->telepon], ['Email', $demo->email], ['Jam layanan', $demo->jam_layanan]] as [$l, $v])
                @if($v)
                <div class="rounded-2xl border border-stone-200 p-5">
                    <div class="label-seksi">{{ $l }}</div>
                    <div class="mt-1 text-stone-800">{{ $v }}</div>
                </div>
                @endif
            @endforeach
            <a href="{{ $demo->linkWa('Halo ' . $demo->nama . ', saya ingin bertanya.') }}" target="_blank" rel="noopener"
               class="flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 p-4 font-semibold text-white hover:bg-emerald-500">Chat WhatsApp</a>
        </div>
        <div class="rounded-2xl bg-stone-50 p-6 sm:p-8 lg:col-span-3">
            <h2 class="mb-6 font-display text-2xl font-bold text-stone-900">Kirim pesan</h2>
            <x-form-kiriman tipe="pesan" tombol="Kirim Pesan" :kolom="[['data.pesan', 'Pesan', 'textarea', true]]" />
        </div>
    </div>
</section>
@endsection
