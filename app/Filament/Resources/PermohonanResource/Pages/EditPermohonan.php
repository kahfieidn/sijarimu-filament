<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Filament\Actions;
use App\Models\Perizinan;
use App\Models\Permohonan;
use App\Models\StatusPermohonan;
use App\Models\PerizinanLifecycle;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
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
        $role = auth()->user()->roles->first()->id;

        if ($perizinan->perizinan_lifecycle_id) {
            foreach ($flows as $item) {
                if (isset($item['flow'])) {
                    $flow_name = $item['flow'];

                    if (in_array("$role", $item['role_id'])) {
                        $data[$flow_name] = true;
                    }
                }
            }
        }

        $data['status_permohonan_id_from_edit'] = $data['status_permohonan_id'];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $perizinan = Perizinan::where('id', $data['perizinan_id'])->first();
        $perizinan_lifecycle_id = Perizinan::where('id', $data['perizinan_id'])->first()->pluck('perizinan_lifecycle_id')->first();

        $flow_status = PerizinanLifecycle::where('id', $perizinan_lifecycle_id)
            ->pluck('flow_status');

        $options = null;
        foreach ($flow_status as $item) {
            foreach ($item as $roleData) {
                if ($roleData['role'] == auth()->user()->roles->first()->id) {
                    $options = $roleData['default_status'];
                    break 2;
                }
            }
        }

        if (auth()->user()->roles->first()->name == 'pemohon' && $data['status_permohonan_id'] == 2) {
            foreach ($data['berkas'] as &$berkas) {
                $berkas['status'] = "pending";
                $berkas['keterangan'] = "-";
            }
            $data['message'] = null;
            $data['status_permohonan_id'] = $options;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn ($record) => auth()->user()->roles->first()->name == 'super_admin'),
            Actions\ViewAction::make(),
            Actions\Action::make('Draft Izin')
                ->url(fn (Permohonan $record): string => route('app.cetak.izin.request', $record))
                ->openUrlInNewTab()
        ];
    }
}
