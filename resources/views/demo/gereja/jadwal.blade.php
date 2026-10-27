@extends('demo.layout')
@section('judul', 'Jadwal Ibadah')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Jadwal Ibadah', 'sub' => 'Mari beribadah bersama. Semua ibadah terbuka untuk umum.'])
<section>
    <div class="mx-auto max-w-4xl px-4 py-14 sm:px-6">
        <div class="divide-y divide-stone-200 overflow-hidden rounded-2xl border border-stone-200">
            @foreach($demo->itemsTipe('jadwal') as $j)
            <div class="grid gap-2 p-5 sm:grid-cols-[120px_1fr_auto] sm:items-center">
                <div class="font-display text-3xl font-semibold text-c">{{ $j->d('jam') }}</div>
                <div>
                    <div class="font-semibold text-stone-900">{{ $j->nama }}</div>
                    <div class="text-sm text-stone-500">{{ $j->deskripsi }}</div>
                </div>
                <div class="text-sm font-semibold uppercase tracking-wider text-a">{{ $j->subjudul }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
