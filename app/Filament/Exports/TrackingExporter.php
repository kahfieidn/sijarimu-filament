<?php

namespace App\Filament\Exports;

use App\Models\Tracking;
use App\Models\Permohonan;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class TrackingExporter extends Exporter
{
    protected static ?string $model = Permohonan::class;

    public static function getColumns(): array
    {
        return [
            //
            ExportColumn::make('profile_usaha.nama_perusahaan')
                ->default(fn ($record) => $record->profile_usaha->nama_perusahaan ?? fn ($record) => $record->user->name)
                ->label('Perusahaan'),
            ExportColumn::make('perizinan.nama_perizinan')
                ->label('Perizinan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tracking export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
