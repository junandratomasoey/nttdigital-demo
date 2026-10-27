<?php
namespace App\Filament\Resources\KirimanResource\Pages;
use App\Filament\Resources\KirimanResource;
use Filament\Resources\Pages\ViewRecord;
class ViewKiriman extends ViewRecord
{
    protected static string $resource = KirimanResource::class;
    protected function mutateFormDataBeforeFill(array $data): array { return $data; }
    public function mount(int|string $record): void
    {
        parent::mount($record);
        if ($this->record->status === "baru") { $this->record->update(["status" => "diproses"]); }
    }
}
