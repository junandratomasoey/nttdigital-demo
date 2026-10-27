@extends('demo.layout')
@section('judul', $post->judul)
@section('konten')
<article>
    <header class="motif bg-c text-white">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 md:py-16">
            <nav class="mb-3 text-xs text-white/70"><a href="/" class="hover:text-white">Beranda</a> / <a href="/{{ $demo->konfig('post.1') }}" class="hover:text-white">{{ $demo->konfig('post.0') }}</a></nav>
            <h1 class="font-display text-3xl font-bold leading-tight md:text-4xl">{{ $post->judul }}</h1>
            <p class="mt-4 text-sm text-white/75">
                {{ $post->tanggal->translatedFormat('l, d F Y') }}@if($post->penulis) · {{ $post->penulis }}@endif @if($post->kategori) · {{ $post->kategori }}@endif
            </p>
        </div>
    </header>
    <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6">
        <x-gambar :src="$post->gambar" :label="$post->kategori ?: $post->judul" class="mb-8 aspect-[16/9] rounded-2xl" />
        <div class="prose-demo">{!! $post->isi !!}</div>
        <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-stone-200 pt-6 text-sm">
            <span class="text-stone-500">Bagikan:</span>
            <a href="https://wa.me/?text={{ urlencode($post->judul . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="rounded-full bg-emerald-50 px-3 py-1.5 font-medium text-emerald-700 hover:bg-emerald-100">WhatsApp</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="rounded-full bg-blue-50 px-3 py-1.5 font-medium text-blue-700 hover:bg-blue-100">Facebook</a>
        </div>
    </div>
</article>
@if($lain->isNotEmpty())
<section class="bg-stone-50">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <h2 class="mb-6 font-display text-2xl font-bold text-stone-900">{{ $demo->konfig('post.0') }} lainnya</h2>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach($lain as $post) @include('demo.shared.kartu-post') @endforeach
        </div>
    </div>
</section>
@endif
@endsection
