<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KirimanResource\Pages;
use App\Models\Kiriman;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KirimanResource extends Resource
{
    protected static ?string $model = Kiriman::class;
    protected static ?string $slug = 'kiriman';
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationLabel = 'Kiriman Masuk';
    protected static ?string $modelLabel = 'Kiriman';
    protected static ?string $pluralModelLabel = 'Kiriman Masuk';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $n = app()->bound('demo') ? Kiriman::where('status', 'baru')->count() : 0;
        return $n ? (string) $n : null;
    }

    private static function tipe(): array
    {
        return app()->bound('demo') ? app('demo')->konfig('form', []) : [];
    }

    public static function canCreate(): bool { return false; }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make()->schema([
                Infolists\Components\TextEntry::make('tipe')->formatStateUsing(fn ($state) => static::tipe()[$state] ?? $state)->badge(),
                Infolists\Components\TextEntry::make('created_at')->label('Waktu')->dateTime('d M Y H:i'),
                Infolists\Components\TextEntry::make('nama'),
                Infolists\Components\TextEntry::make('kontak')->placeholder('-'),
                Infolists\Components\KeyValueEntry::make('data')->label('Isian')->columnSpanFull()
                    ->keyLabel('Kolom')->valueLabel('Isi'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Waktu')->dateTime('d M Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('tipe')->badge()->formatStateUsing(fn ($state) => static::tipe()[$state] ?? $state),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('kontak'),
                Tables\Columns\SelectColumn::make('status')->options(['baru' => 'Baru', 'diproses' => 'Diproses', 'selesai' => 'Selesai']),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([Tables\Filters\SelectFilter::make('tipe')->options(fn () => static::tipe())])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('wa')->label('WA')->icon('heroicon-o-chat-bubble-left')->color('success')
                    ->visible(fn (Kiriman $r) => filled($r->kontak))
                    ->url(fn (Kiriman $r) => 'https://wa.me/' . preg_replace('/^0/', '62', preg_replace('/\D/', '', $r->kontak)) . '?text=' . rawurlencode("Halo {$r->nama}, terima kasih sudah menghubungi " . app('demo')->nama . '.'))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKiriman::route('/'),
            'view'  => Pages\ViewKiriman::route('/{record}'),
        ];
    }
}
