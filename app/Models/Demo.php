<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Demo extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'misi' => 'array',
        'data' => 'array',
    ];

    public function posts(): HasMany   { return $this->hasMany(Post::class); }
    public function items(): HasMany   { return $this->hasMany(Item::class); }
    public function kiriman(): HasMany { return $this->hasMany(Kiriman::class); }

    public function konfig(?string $kunci = null, $default = null)
    {
        $k = config("demo.jenis.{$this->jenis}", []);
        return $kunci ? data_get($k, $kunci, $default) : $k;
    }

    public function d(string $kunci, $default = null)
    {
        return data_get($this->data, $kunci, $default);
    }

    public function url(string $path = '/'): string
    {
        return 'https://demo-' . $this->jenis . '.' . config('demo.domain') . $path;
    }

    public function linkWa(?string $pesan = null): string
    {
        $no = $this->whatsapp ?: config('demo.whatsapp');
        return 'https://wa.me/' . $no . ($pesan ? '?text=' . rawurlencode($pesan) : '');
    }

    /** Link WhatsApp ke NTT Digital untuk tombol "Pesan website seperti ini". */
    public function linkPesanWebsite(): string
    {
        return 'https://wa.me/' . config('demo.whatsapp') . '?text=' . rawurlencode(
            "Halo NTT Digital, saya sudah lihat demo {$this->konfig('label')} dan tertarik dibuatkan website seperti ini."
        );
    }

    public function itemsTipe(string $tipe)
    {
        return $this->items()->where('tipe', $tipe)->where('aktif', true)->orderBy('urutan')->get();
    }
}
