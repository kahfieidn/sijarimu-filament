<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Filament\Actions;
use App\Models\Perizinan;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PermohonanResource;

class ViewPermohonan extends ViewRecord
{
    protected static string $resource = PermohonanResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $perizinan = Perizinan::find($data['perizinan_id']);
        $flows = $perizinan->perizinan_lifecycle->flow;

        if ($perizinan->perizinan_lifecycle_id) {
            foreach ($flows as $item) {
                if (isset($item['flow'])) {
                    $flow_name = $item['flow'];
                    $data[$flow_name] = true; // Corrected line
                }
            }
        }

        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
