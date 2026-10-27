<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * Satu resource untuk semua daftar konten: produk, kamar, guru, surat, jadwal, dll.
 * Jenis yang tersedia mengikuti config/demo.php -> jenis.{jenis}.item
 */
class ItemResource extends Resource
{
    protected static ?string $model = Item::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Konten Halaman';
    protected static ?string $modelLabel = 'Konten';
    protected static ?string $pluralModelLabel = 'Konten Halaman';
    protected static ?int $navigationSort = 2;

    public static function tipe(): array
    {
        return app()->bound('demo') ? app('demo')->konfig('item', []) : [];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('tipe')->options(static::tipe())->required()->native(false)
                    ->default(request()->query('tipe')),
                Forms\Components\TextInput::make('nama')->required()->maxLength(200),
                Forms\Components\TextInput::make('subjudul')->maxLength(200)
                    ->helperText('Mis. jabatan, kategori produk, ukuran kamar, atau nilai statistik.'),
                Forms\Components\TextInput::make('harga')->numeric()->prefix('Rp')
                    ->helperText('Untuk produk, kamar, atau anggaran APBDes.'),
                Forms\Components\TextInput::make('ikon')->maxLength(8)->helperText('Satu emoji, opsional.'),
                Forms\Components\TextInput::make('urutan')->numeric()->default(0),
                Forms\Components\Textarea::make('deskripsi')->rows(3)->columnSpanFull(),
                Forms\Components\FileUpload::make('gambar')->image()->directory('demo-upload/item')->maxSize(2048)->columnSpanFull(),
                Forms\Components\KeyValue::make('data')->label('Data tambahan')
                    ->keyLabel('Kolom')->valueLabel('Isi')->columnSpanFull()
                    ->helperText('Kolom khusus seperti satuan, warna, jam, nomor rekening.')
                    ->formatStateUsing(fn ($state) => collect($state ?? [])->filter(fn ($v) => ! is_array($v))->map(fn ($v) => is_bool($v) ? ($v ? '1' : '0') : (string) $v)->all())
                    ->dehydrateStateUsing(fn ($state, ?Item $record) => array_merge(
                        collect($record?->data ?? [])->filter(fn ($v) => is_array($v))->all(), $state ?? []
                    )),
                Forms\Components\Toggle::make('aktif')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipe')->badge()
                    ->formatStateUsing(fn ($state) => static::tipe()[$state] ?? $state),
                Tables\Columns\TextColumn::make('ikon')->label(''),
                Tables\Columns\TextColumn::make('nama')->searchable()->wrap()->description(fn (Item $r) => $r->subjudul),
                Tables\Columns\TextColumn::make('harga')->money('IDR', locale: 'id')->toggleable(),
                Tables\Columns\ToggleColumn::make('aktif'),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->defaultGroup('tipe')
            ->groups([Tables\Grouping\Group::make('tipe')->getTitleFromRecordUsing(fn (Item $r) => static::tipe()[$r->tipe] ?? $r->tipe)])
            ->filters([Tables\Filters\SelectFilter::make('tipe')->options(fn () => static::tipe())])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit'   => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
