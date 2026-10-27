<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Website – NTT Digital</title>
    <meta name="robots" content="noindex">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
    <style>:root{--c:#0F6E56;--a:#C98A1B;--f-body:"Plus Jakarta Sans";--f-display:"Plus Jakarta Sans"}</style>
</head>
<body class="bg-stone-50 text-stone-800">
    <main class="mx-auto max-w-5xl px-4 py-16 sm:px-6">
        <p class="label-seksi">NTT Digital</p>
        <h1 class="mt-2 text-4xl font-bold text-stone-900">Demo website</h1>
        <p class="mt-3 max-w-xl text-stone-600">Pilih demo untuk melihat contoh website. Semua nama dan data adalah fiktif.</p>
        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($demos as $d)
            @php $lokal = ! str_ends_with(request()->getHost(), config('demo.domain')); @endphp
            <a href="{{ $lokal ? '/?demo=' . $d->jenis : $d->url() }}" class="group overflow-hidden rounded-2xl border border-stone-200 bg-white transition hover:shadow-lg">
                <div class="motif h-28" style="background: linear-gradient(135deg, {{ $d->warna }}, {{ $d->warna_aksen }})"></div>
                <div class="p-5">
                    <div class="text-xs font-bold uppercase tracking-wider" style="color: {{ $d->warna }}">{{ $d->konfig('label') }}</div>
                    <div class="mt-1 text-lg font-bold text-stone-900">{{ $d->nama }}</div>
                    <div class="mt-1 text-sm text-stone-500">{{ $lokal ? '?demo=' . $d->jenis : 'demo-' . $d->jenis . '.' . config('demo.domain') }}</div>
                </div>
            </a>
            @endforeach
        </div>
        <p class="mt-10 text-sm text-stone-500"><a href="{{ config('demo.situs_utama') }}" class="font-semibold underline">Kembali ke nttdigital.site</a></p>
    </main>
</body>
</html>
