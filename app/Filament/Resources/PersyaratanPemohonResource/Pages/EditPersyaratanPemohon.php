<?php

namespace App\Filament\Resources\PersyaratanPemohonResource\Pages;

use App\Filament\Resources\PersyaratanPemohonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersyaratanPemohon extends EditRecord
{
    protected static string $resource = PersyaratanPemohonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
