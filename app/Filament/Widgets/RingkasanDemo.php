<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\Kiriman;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RingkasanDemo extends BaseWidget
{
    protected function getStats(): array
    {
        $demo = app('demo');

        return [
            Stat::make('Kiriman baru', Kiriman::where('status', 'baru')->count())
                ->description('Dari formulir di website')->color('danger'),
            Stat::make($demo->konfig('post.0'), Post::count())->description('Tulisan diterbitkan'),
            Stat::make('Konten halaman', Item::count())->description('Produk, jadwal, data, dll.'),
        ];
    }
}
