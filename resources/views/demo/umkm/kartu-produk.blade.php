<a href="/produk/{{ $p->slug }}" class="group block">
    <div class="overflow-hidden rounded-xl">
        <x-gambar :src="$p->gambar" :label="$p->nama" :warna="$p->d('warna')" class="aspect-[3/4] transition duration-500 group-hover:scale-105" />
    </div>
    <div class="mt-3 text-xs uppercase tracking-wider text-stone-500">{{ $p->subjudul }}</div>
    <div class="mt-1 font-display text-lg leading-snug text-stone-900 group-hover:text-c">{{ $p->nama }}</div>
    <div class="mt-1 text-sm font-bold text-c">{{ $p->harga_rp }}</div>
</a>
