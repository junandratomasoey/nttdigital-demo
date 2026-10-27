@extends('demo.layout')
@section('judul', 'Guru & Staf')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Guru & Staf', 'sub' => 'Pendidik dan tenaga kependidikan ' . $demo->nama . '.'])
<section class="bg-stone-50">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <div class="grid grid-cols-2 gap-5 md:grid-cols-3 lg:grid-cols-4">
            @foreach($demo->itemsTipe('guru') as $g)
            <div class="rounded-3xl bg-white p-5 text-center">
                <x-gambar :src="$g->gambar" :label="$g->nama" :ikon="$g->ikon" class="mx-auto aspect-square w-24 rounded-full" />
                <div class="mt-3 font-bold text-stone-900">{{ $g->nama }}</div>
                <div class="text-sm text-c">{{ $g->subjudul }}</div>
                @if($g->deskripsi)<div class="mt-1 text-xs text-stone-500">{{ $g->deskripsi }}</div>@endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
