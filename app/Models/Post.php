<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use MilikDemo;

    protected $guarded = ['id'];
    protected $casts = ['tanggal' => 'date', 'terbit' => 'boolean'];

    protected static function booted(): void
    {
        static::saving(fn (Post $p) => $p->slug = $p->slug ?: Str::slug($p->judul));
    }

    public function scopeTerbit($q)
    {
        return $q->where('terbit', true)->orderByDesc('tanggal')->orderByDesc('id');
    }

    public function getRingkasAttribute(): string
    {
        return $this->ringkasan ?: Str::limit(trim(strip_tags($this->isi)), 150);
    }
}
