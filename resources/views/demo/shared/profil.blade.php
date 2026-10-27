@extends('demo.layout')
@section('judul', 'Profil')
@section('konten')
@include('demo.shared.kepala', ['judul' => $demo->d('judul_profil', 'Profil'), 'sub' => $demo->tagline])
<section>
    <div class="mx-auto grid max-w-6xl gap-12 px-4 py-14 sm:px-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="prose-demo">{!! $demo->profil !!}</div>
        </div>
        <aside class="space-y-6">
            @if($demo->visi)
            <div class="rounded-2xl bg-c-soft p-6">
                <div class="label-seksi">Visi</div>
                <p class="mt-2 font-display text-xl font-semibold leading-snug text-stone-900">“{{ $demo->visi }}”</p>
            </div>
            @endif
            @if($demo->misi)
            <div class="rounded-2xl border border-stone-200 p-6">
                <div class="label-seksi">Misi</div>
                <ol class="mt-3 space-y-2 text-sm text-stone-700">
                    @foreach($demo->misi as $m)
                    <li class="flex gap-3"><span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-c text-xs font-bold text-white">{{ $loop->iteration }}</span>{{ $m }}</li>
                    @endforeach
                </ol>
            </div>
            @endif
        </aside>
    </div>
</section>
@php $orang = $demo->itemsTipe($demo->d('tipe_orang', 'perangkat')); @endphp
@if($orang->isNotEmpty())
<section class="bg-stone-50">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <h2 class="judul-seksi mb-8">{{ $demo->konfig('item.' . $demo->d('tipe_orang', 'perangkat')) }}</h2>
        <div class="grid grid-cols-2 gap-5 md:grid-cols-4">
            @foreach($orang as $o)
            <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white text-center">
                <x-gambar :src="$o->gambar" :label="$o->nama" class="aspect-square" :ikon="$o->ikon" />
                <div class="p-4">
                    <div class="font-semibold text-stone-900">{{ $o->nama }}</div>
                    <div class="text-sm text-c">{{ $o->subjudul }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
