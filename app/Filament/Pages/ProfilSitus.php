<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ProfilSitus extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Profil & Tampilan';
    protected static ?string $title = 'Profil & Tampilan';
    protected static ?int $navigationSort = 0;
    protected static string $view = 'filament.profil-situs';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(app('demo')->only([
            'nama', 'tagline', 'hero_judul', 'hero_sub', 'hero_gambar', 'warna', 'warna_aksen',
            'alamat', 'telepon', 'whatsapp', 'email', 'jam_layanan', 'visi', 'misi', 'profil', 'deskripsi',
        ]));
    }

    public function form(Form $form): Form
    {
        return $form->statePath('data')->schema([
            Forms\Components\Tabs::make()->tabs([
                Forms\Components\Tabs\Tab::make('Identitas & Beranda')->schema([
                    Forms\Components\TextInput::make('nama')->required()->maxLength(120),
                    Forms\Components\Textarea::make('tagline')->rows(2)->maxLength(250),
                    Forms\Components\TextInput::make('hero_judul')->label('Judul besar di beranda')->maxLength(150),
                    Forms\Components\Textarea::make('hero_sub')->label('Teks di bawah judul')->rows(2),
                    Forms\Components\FileUpload::make('hero_gambar')->label('Foto beranda')->image()->directory('demo-upload/hero')->maxSize(3072),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\ColorPicker::make('warna')->label('Warna utama')->required(),
                        Forms\Components\ColorPicker::make('warna_aksen')->label('Warna aksen')->required(),
                    ]),
                ]),
                Forms\Components\Tabs\Tab::make('Kontak')->schema([
                    Forms\Components\TextInput::make('alamat'),
                    Forms\Components\TextInput::make('telepon'),
                    Forms\Components\TextInput::make('whatsapp')->helperText('Format 62xxxxxxxxxx'),
                    Forms\Components\TextInput::make('email')->email(),
                    Forms\Components\TextInput::make('jam_layanan'),
                ])->columns(2),
                Forms\Components\Tabs\Tab::make('Profil')->schema([
                    Forms\Components\Textarea::make('deskripsi')->label('Deskripsi singkat')->rows(3),
                    Forms\Components\Textarea::make('visi')->rows(2),
                    Forms\Components\Repeater::make('misi')->simple(Forms\Components\TextInput::make('misi')->required())->addActionLabel('+ Tambah misi'),
                    Forms\Components\RichEditor::make('profil')->label('Halaman profil')
                        ->toolbarButtons(['h2', 'h3', 'bold', 'italic', 'link', 'bulletList', 'orderedList', 'blockquote', 'undo', 'redo']),
                ]),
            ]),
        ]);
    }

    public function simpan(): void
    {
        app('demo')->update($this->form->getState());
        Notification::make()->title('Tersimpan. Buka website untuk melihat perubahannya.')->success()->send();
    }
}
