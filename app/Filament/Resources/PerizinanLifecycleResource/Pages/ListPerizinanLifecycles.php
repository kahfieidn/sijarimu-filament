<?php

namespace App\Filament\Resources\PerizinanLifecycleResource\Pages;

use App\Filament\Resources\PerizinanLifecycleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPerizinanLifecycles extends ListRecords
{
    protected static string $resource = PerizinanLifecycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
