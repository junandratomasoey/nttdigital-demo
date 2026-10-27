@extends('demo.layout')
@section('judul', 'Pelayanan')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Pelayanan Kategorial', 'sub' => 'Wadah persekutuan dan pelayanan untuk setiap kelompok usia.'])
<section>
    <div class="mx-auto grid max-w-6xl gap-6 px-4 py-14 sm:px-6 md:grid-cols-2">
        @foreach($demo->itemsTipe('pelayanan') as $p)
        <div class="flex gap-5 rounded-2xl border border-stone-200 p-6">
            <div class="text-4xl" aria-hidden="true">{{ $p->ikon }}</div>
            <div>
                <h2 class="font-display text-2xl font-semibold text-stone-900">{{ $p->nama }}</h2>
                <p class="mt-2 text-stone-600">{{ $p->deskripsi }}</p>
                <p class="mt-3 text-sm font-semibold text-c">{{ $p->subjudul }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
