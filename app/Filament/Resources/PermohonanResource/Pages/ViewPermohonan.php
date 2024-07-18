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
        $role = auth()->user()->roles->first()->id;
        
        if ($perizinan->perizinan_lifecycle_id) {
            foreach ($flows as $item) {
                if (isset($item['flow'])) {
                    $flow_name = $item['flow'];

                    if (in_array("$role", $item['role_id']) && $item['condition_status'] == null) {
                        $data[$flow_name] = true;
                    } else if (in_array("$role", $item['role_id']) && $item['condition_status'] == $data['status_permohonan_id']) {
                        $data[$flow_name] = true;
                    }
                }
            }
        }
        $data['status_permohonan_id_from_edit'] = $data['status_permohonan_id'];


        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
