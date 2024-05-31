<?php

namespace App\Filament\Resources\FormulirResource\Pages;

use App\Filament\Resources\FormulirResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormulir extends EditRecord
{
    protected static string $resource = FormulirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
