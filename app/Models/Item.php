<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Item extends Model
{
    use MilikDemo;

    protected $guarded = ['id'];
    protected $casts = ['data' => 'array', 'aktif' => 'boolean'];

    protected static function booted(): void
    {
        static::saving(fn (Item $i) => $i->slug = $i->slug ?: Str::slug($i->nama));
    }

    public function d(string $kunci, $default = null)
    {
        return data_get($this->data, $kunci, $default);
    }

    public function getHargaRpAttribute(): ?string
    {
        return $this->harga ? 'Rp ' . number_format($this->harga, 0, ',', '.') : null;
    }
}
