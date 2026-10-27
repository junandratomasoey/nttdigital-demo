@extends('demo.layout')
@section('judul', 'Fasilitas')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Fasilitas', 'sub' => 'Semua yang Anda butuhkan untuk beristirahat dan bekerja dengan nyaman.'])
<section>
    <div class="mx-auto grid max-w-6xl gap-6 px-4 py-14 sm:px-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($demo->itemsTipe('fasilitas') as $f)
        <div class="rounded-2xl border border-stone-200 p-6">
            <div class="grid h-12 w-12 place-items-center rounded-full bg-c-soft text-2xl" aria-hidden="true">{{ $f->ikon }}</div>
            <h2 class="mt-4 font-display text-2xl font-medium text-stone-900">{{ $f->nama }}</h2>
            <p class="mt-1 text-sm font-semibold text-c">{{ $f->subjudul }}</p>
            <p class="mt-2 font-light text-stone-600">{{ $f->deskripsi }}</p>
        </div>
        @endforeach
    </div>
</section>
@endsection
