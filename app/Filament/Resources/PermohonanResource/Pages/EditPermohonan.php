<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Filament\Actions;
use App\Models\Perizinan;
use App\Models\Permohonan;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PermohonanResource;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class EditPermohonan extends EditRecord
{

    protected static string $resource = PermohonanResource::class;

    public function mount(string | int $record): void
    {
        $permohonan = Permohonan::findOrFail($record); // Fetch the Permohonan record by ID
        if ($permohonan->status_permohonan_id != 2 && auth()->user()->roles->first()->name == 'pemohon') {
            abort(403);
        }
        parent::mount($record);
    }
    

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
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
