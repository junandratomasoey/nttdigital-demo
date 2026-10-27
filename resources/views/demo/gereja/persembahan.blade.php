@extends('demo.layout')
@section('judul', 'Persembahan & Doa')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Persembahan & Doa', 'sub' => 'Dukung pelayanan jemaat dan kirimkan pokok doa Anda.'])
<section>
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2">
        <div>
            <h2 class="font-display text-3xl font-semibold text-stone-900">Persembahan</h2>
            <p class="mt-2 text-stone-600">Persembahan dapat disalurkan melalui rekening jemaat berikut.</p>
            <div class="mt-6 space-y-4">
                @foreach($demo->itemsTipe('rekening') as $r)
                <div class="rounded-2xl border border-stone-200 p-5" x-data="{ salin: false }">
                    <div class="text-sm text-stone-500">{{ $r->nama }} · {{ $r->subjudul }}</div>
                    <div class="mt-1 flex flex-wrap items-center gap-3">
                        <span class="font-mono text-xl font-semibold tracking-wider text-stone-900">{{ $r->d('nomor') }}</span>
                        <button type="button" class="rounded-full border border-stone-300 px-3 py-1 text-xs font-semibold"
                                @click="navigator.clipboard?.writeText(@js($r->d('nomor'))); salin = true; setTimeout(() => salin = false, 1500)"
                                x-text="salin ? 'Tersalin' : 'Salin'">Salin</button>
                    </div>
                    <div class="mt-1 text-sm text-stone-600">a.n. {{ $r->d('atas_nama') }}</div>
                </div>
                @endforeach
                <p class="text-xs text-stone-500">Nomor rekening di halaman demo ini fiktif dan tidak dapat digunakan.</p>
            </div>
        </div>
        <div class="rounded-2xl bg-a-soft p-6 sm:p-8">
            <h2 class="mb-2 font-display text-3xl font-semibold text-stone-900">Permohonan doa</h2>
            <p class="mb-6 text-sm text-stone-600">Pokok doa hanya dibaca oleh majelis jemaat.</p>
            <x-form-kiriman tipe="doa" tombol="Kirim Pokok Doa" label-kontak="Nomor HP (opsional)"
                pesan-sukses="Pokok doa Anda sudah kami terima. Tuhan memberkati."
                :kolom="[
                    ['data.sektor', 'Rayon / sektor', 'text'],
                    ['data.pokok_doa', 'Pokok doa', 'textarea', true],
                ]" />
        </div>
    </div>
</section>
@endsection
