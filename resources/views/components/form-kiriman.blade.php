{{--
    Form yang benar-benar tersimpan (bisa dilihat di panel admin → Kiriman Masuk).
    $kolom: [['data.nik', 'NIK', 'text', required?, opsi?], ...]
    Kolom "nama" & "kontak" selalu ada.
--}}
@props(['tipe', 'kolom' => [], 'tombol' => 'Kirim', 'labelKontak' => 'Nomor HP / WhatsApp', 'gelap' => false, 'pesanSukses' => null])
@php
    $kelasLabel = $gelap ? 'mb-1.5 block text-sm font-medium text-white/80' : 'label';
    $nama = fn ($k) => str_contains($k, '.') ? preg_replace('/^data\.(.+)$/', 'data[$1]', $k) : $k;
@endphp
<div id="form" {{ $attributes }}>
    @if(session('terkirim') === $tipe)
    <div class="mb-5 rounded-xl border border-emerald-300 bg-emerald-50 p-4 text-sm text-emerald-900" role="status">
        <strong>Terkirim.</strong> {{ $pesanSukses ?? 'Terima kasih, data Anda sudah kami terima. Petugas akan menghubungi Anda.' }}
        <span class="mt-1 block text-emerald-700">(Ini demo: kiriman tampil di panel admin → Kiriman Masuk.)</span>
    </div>
    @endif

    <form method="POST" action="{{ route('kirim', $tipe) }}" class="grid gap-4 sm:grid-cols-2">
        @csrf
        <div class="hidden" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>

        <div class="sm:col-span-2">
            <label for="f-{{ $tipe }}-nama" class="{{ $kelasLabel }}">Nama lengkap *</label>
            <input id="f-{{ $tipe }}-nama" name="nama" value="{{ old('nama') }}" required maxlength="100" class="input" autocomplete="name">
            @error('nama')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
            <label for="f-{{ $tipe }}-kontak" class="{{ $kelasLabel }}">{{ $labelKontak }}{{ in_array($tipe, ['surat','ppdb','reservasi']) ? ' *' : '' }}</label>
            <input id="f-{{ $tipe }}-kontak" name="kontak" value="{{ old('kontak') }}" maxlength="60" inputmode="tel" class="input" autocomplete="tel">
            @error('kontak')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        @foreach($kolom as $k)
            @php [$kunci, $label, $jenisInput] = $k; $wajib = $k[3] ?? false; $opsi = $k[4] ?? []; $lebar = $k[5] ?? 'sm:col-span-1'; $awal = old($kunci, isset($k[6]) ? request()->query($k[6]) : null); $id = 'f-' . $tipe . '-' . \Illuminate\Support\Str::slug(str_replace(['.', '_'], '-', $kunci)); @endphp
            <div class="{{ $jenisInput === 'textarea' ? 'sm:col-span-2' : $lebar }}">
                <label for="{{ $id }}" class="{{ $kelasLabel }}">{{ $label }}{{ $wajib ? ' *' : '' }}</label>
                @if($jenisInput === 'select')
                    <select id="{{ $id }}" name="{{ $nama($kunci) }}" class="input" @required($wajib)>
                        <option value="">Pilih…</option>
                        @foreach($opsi as $o)<option @selected($awal === $o)>{{ $o }}</option>@endforeach
                    </select>
                @elseif($jenisInput === 'textarea')
                    <textarea id="{{ $id }}" name="{{ $nama($kunci) }}" rows="3" maxlength="1000" class="input" @required($wajib)>{{ $awal }}</textarea>
                @else
                    <input id="{{ $id }}" type="{{ $jenisInput }}" name="{{ $nama($kunci) }}" value="{{ $awal }}" class="input" @required($wajib)>
                @endif
            </div>
        @endforeach

        <div class="sm:col-span-2">
            <button type="submit" class="btn-c w-full sm:w-auto">{{ $tombol }}</button>
        </div>
    </form>
</div>
