@extends('demo.layout')
@section('judul', 'Kamar')
@section('konten')
@include('demo.shared.kepala', ['judul' => 'Kamar & Suite', 'sub' => 'Semua kamar dilengkapi AC, Wi-Fi, air panas, dan sarapan untuk dua orang.'])
<section class="bg-[#F6F1E9]">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-16 sm:px-6 md:grid-cols-3">
        @foreach($demo->itemsTipe('kamar') as $k) @include('demo.hotel.kartu-kamar') @endforeach
    </div>
</section>
@endsection
