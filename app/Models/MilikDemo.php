<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Membatasi semua query ke demo yang sedang dibuka (app('demo')),
 * dan otomatis mengisi demo_id saat membuat data baru.
 */
trait MilikDemo
{
    protected static function bootMilikDemo(): void
    {
        static::addGlobalScope('demo', function (Builder $q) {
            if (app()->bound('demo')) {
                $q->where($q->getModel()->getTable() . '.demo_id', app('demo')->id);
            }
        });

        static::creating(function ($model) {
            if (blank($model->demo_id) && app()->bound('demo')) {
                $model->demo_id = app('demo')->id;
            }
        });
    }

    public function demo(): BelongsTo
    {
        return $this->belongsTo(Demo::class);
    }
}
