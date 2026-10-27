{{-- Pita penanda: ini website demo NTT Digital, bukan situs resmi --}}
<div class="relative z-50 bg-stone-900 text-stone-200" x-data="{ info: false }">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-x-4 gap-y-2 px-4 py-2 text-xs sm:px-6">
        <p class="flex items-center gap-2">
            <span class="rounded bg-amber-400 px-1.5 py-0.5 font-bold tracking-wider text-stone-900">DEMO</span>
            <span>Contoh {{ $demo->konfig('label') }} buatan <a href="{{ config('demo.situs_utama') }}" class="font-semibold text-white underline-offset-2 hover:underline">NTT Digital</a>. Nama &amp; data fiktif.</span>
        </p>
        <div class="flex items-center gap-2">
            <button type="button" @click="info = !info" :aria-expanded="info"
                    class="rounded-full border border-white/25 px-3 py-1 font-semibold text-white hover:bg-white/10">Coba panel admin</button>
            <a href="{{ $demo->linkPesanWebsite() }}" target="_blank" rel="noopener"
               class="rounded-full bg-emerald-500 px-3 py-1 font-semibold text-white hover:bg-emerald-400">Pesan website seperti ini</a>
        </div>
    </div>
    <div x-cloak x-show="info" x-transition class="border-t border-white/10 bg-stone-800">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-x-6 gap-y-2 px-4 py-3 text-sm sm:px-6">
            <span>Masuk ke <a href="/admin" class="font-semibold text-white underline">/admin</a> dengan:</span>
            <span>Email <code class="select-all rounded bg-black/40 px-2 py-0.5 text-white">{{ "admin@" . $demo->jenis . ".demo" }}</code></span>
            <span>Kata sandi <code class="select-all rounded bg-black/40 px-2 py-0.5 text-white">{{ config('demo.admin_password') }}</code></span>
            <span class="text-stone-400">Silakan ubah apa saja — data kembali seperti semula setiap pukul 02.00 WITA.</span>
        </div>
    </div>
</div>
