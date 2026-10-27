@extends('demo.layout')
@section('judul', $judul)
@section('konten')
@include('demo.shared.kepala', ['judul' => $judul, 'sub' => $demo->d('sub_post', 'Kabar dan informasi terbaru dari ' . $demo->nama . '.')])
<section class="bg-stone-50">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($posts as $post)
                @include('demo.shared.kartu-post')
            @empty
                <p class="text-stone-500">Belum ada {{ strtolower($judul) }}.</p>
            @endforelse
        </div>
        <div class="mt-10">{{ $posts->links() }}</div>
    </div>
</section>
@endsection
