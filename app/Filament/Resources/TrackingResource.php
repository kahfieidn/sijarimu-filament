<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Permohonan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Custom\Path\Models\Permohonan\Tracking;
use App\Filament\Resources\TrackingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TrackingResource\RelationManagers;

class TrackingResource extends Resource
{
    protected static ?string $model = Permohonan::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $pluralModelLabel = 'Tracking';

    protected static ?string $navigationGroup = 'Pengajuan';

    protected static ?int $navigationGroupSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('perizinan.nama_perizinan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('perizinan.sektor.nama_sektor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_permohonan.general_status')
                    ->badge()
                    ->color(fn ($record): string => $record->status_permohonan->color)
                    ->icon(fn ($record): string => $record->status_permohonan->icon)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->striped()
            ->filters([
                SelectFilter::make('nama_sektor')
                    ->relationship('perizinan.sektor', 'nama_sektor')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('nama_perizinan')
                    ->relationship('perizinan', 'nama_perizinan')
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrackings::route('/'),
            'create' => Pages\CreateTracking::route('/create'),
            'view' => Pages\ViewTracking::route('/{record}'),
            'edit' => Pages\EditTracking::route('/{record}/edit'),
        ];
    }
}
