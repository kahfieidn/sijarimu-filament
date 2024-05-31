<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use App\Filament\Resources\PermohonanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePermohonan extends CreateRecord
{
    protected static string $resource = PermohonanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['status_permohonan_id'] = 1;
        return $data;
    }
}
