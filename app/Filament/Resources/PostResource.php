<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 1;

    private static function label(): string
    {
        return app()->bound('demo') ? app('demo')->konfig('post.0', 'Berita') : 'Berita';
    }

    public static function getNavigationLabel(): string { return static::label(); }
    public static function getModelLabel(): string { return static::label(); }
    public static function getPluralModelLabel(): string { return static::label(); }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('judul')->required()->maxLength(200)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set, ?Post $record) => $record ? null : $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->maxLength(200),
                Forms\Components\TextInput::make('kategori')->maxLength(60)
                    ->datalist(fn () => Post::query()->distinct()->pluck('kategori')->filter()->values()->all()),
                Forms\Components\DatePicker::make('tanggal')->required()->default(now()),
                Forms\Components\RichEditor::make('isi')->required()->columnSpanFull()
                    ->fileAttachmentsDirectory('demo-upload/lampiran')
                    ->toolbarButtons(['h2', 'h3', 'bold', 'italic', 'link', 'bulletList', 'orderedList', 'blockquote', 'attachFiles', 'undo', 'redo']),
                Forms\Components\FileUpload::make('gambar')->image()->directory('demo-upload/post')->maxSize(2048)->columnSpanFull(),
                Forms\Components\Toggle::make('terbit')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('judul')->searchable()->wrap(),
                Tables\Columns\TextColumn::make('kategori')->badge()->color('gray'),
                Tables\Columns\ToggleColumn::make('terbit'),
            ])
            ->defaultSort('tanggal', 'desc')
            ->actions([
                Tables\Actions\Action::make('lihat')->icon('heroicon-o-eye')->color('gray')
                    ->url(fn (Post $r) => '/' . app('demo')->konfig('post.1') . '/' . $r->slug)->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
