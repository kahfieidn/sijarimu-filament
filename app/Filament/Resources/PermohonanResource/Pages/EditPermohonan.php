<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use App\Models\Perizinan;
use App\Models\Permohonan;
use App\Models\Persyaratan;
use App\Models\StatusPermohonan;
use Filament\Infolists\Infolist;
use App\Models\PerizinanLifecycle;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Infolists\Components\TextEntry;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Filament\Resources\PermohonanResource;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;
    protected static ?string $title = 'Tinjau Permohonan';


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

    protected function mutateFormDataBeforeSave(array $data): array
    {
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

        //Set status permohonan unggah berkas to default status
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

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $currentMonthYear = Carbon::now()->format('Y-F');
        $permohonan = Permohonan::find($record->id);

        if ($data['status_permohonan_id'] == 11 && $permohonan->perizinan->is_template == 1) {
            $pdfData = [
                'permohonan' => $permohonan,
            ];

            $storageDirectory = 'izin/' . $currentMonthYear . '/' . $permohonan->id . '.pdf';
            $pdf = FacadePdf::loadView('cetak.izin.request', $pdfData);
            $customPaper = [0, 0, 609.4488, 935.433];
            $pdf->set_paper($customPaper);

            $fileContent = $pdf->output();
            $hashedFileName = hash('sha256', $storageDirectory) . '.' . pathinfo($storageDirectory, PATHINFO_EXTENSION);

            Storage::put('public/izin/' . $currentMonthYear . '/' . $hashedFileName, $fileContent);
            $permohonan->update([
                'izin_terbit' => $currentMonthYear . '/' . $hashedFileName,
                'tanggal_izin_terbit' => Carbon::now(),
            ]);
        }

        $record->update($data);
        return $record;
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn ($record) => auth()->user()->roles->first()->name == 'super_admin'),
            Actions\ViewAction::make(),
            Actions\Action::make('Draft Rekomendasi')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [5, 6, 7, 8, 9, 10, 11]) && $record->perizinan->is_template_rekomendasi == 1)
                ->url(fn (Permohonan $record): string => route('app.cetak.permintaan-rekomendasi-request', $record))
                ->openUrlInNewTab(),
            Actions\Action::make('Draft Kajian Teknis')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [8, 9, 10, 11]) && !is_null($record->kajian_teknis))
                ->url(fn (Permohonan $record): string => url('storage/' . $record->kajian_teknis))
                ->openUrlInNewTab(),
            Actions\Action::make('Draft Izin')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [9, 10, 11]))
                ->url(fn (Permohonan $record): string => route('app.cetak.izin.request', $record))
                ->openUrlInNewTab()
        ];
    }
}
