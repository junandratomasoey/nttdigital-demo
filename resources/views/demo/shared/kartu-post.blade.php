<article class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white transition hover:-translate-y-0.5 hover:shadow-lg">
    <a href="/{{ $demo->konfig('post.1') }}/{{ $post->slug }}" class="block overflow-hidden" tabindex="-1" aria-hidden="true">
        <x-gambar :src="$post->gambar" :label="$post->kategori ?: $demo->konfig('post.0')" class="aspect-[16/9] transition duration-300 group-hover:scale-[1.03]" />
    </a>
    <div class="flex flex-1 flex-col p-5">
        <div class="mb-2 flex items-center gap-2 text-xs text-stone-500">
            @if($post->kategori)<span class="font-semibold text-c">{{ $post->kategori }}</span><span aria-hidden="true">·</span>@endif
            <time datetime="{{ $post->tanggal->toDateString() }}">{{ $post->tanggal->translatedFormat('d F Y') }}</time>
        </div>
        <h3 class="font-display text-lg font-bold leading-snug text-stone-900">
            <a href="/{{ $demo->konfig('post.1') }}/{{ $post->slug }}" class="hover:text-c">{{ $post->judul }}</a>
        </h3>
        <p class="mt-2 line-clamp-3 flex-1 text-sm text-stone-600">{{ $post->ringkas }}</p>
    </div>
</article>
