<article class="group">
    <a href="/kamar/{{ $k->slug }}" class="block overflow-hidden rounded-2xl">
        <x-gambar :src="$k->gambar" :label="$k->nama" :warna="$k->d('warna')" class="aspect-[4/5] transition duration-500 group-hover:scale-105" />
    </a>
    <div class="mt-4 flex items-start justify-between gap-4">
        <div>
            <h3 class="font-display text-2xl font-medium text-stone-900"><a href="/kamar/{{ $k->slug }}" class="hover:text-c">{{ $k->nama }}</a></h3>
            <p class="mt-1 text-sm font-light text-stone-500">{{ $k->subjudul }}</p>
        </div>
        <div class="shrink-0 text-right">
            <div class="text-xs text-stone-500">mulai</div>
            <div class="font-semibold text-c">{{ $k->harga_rp }}</div>
            <div class="text-xs text-stone-500">/ malam</div>
        </div>
    </div>
</article>
