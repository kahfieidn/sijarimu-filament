<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Perizinan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PersyaratanPemohon;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PersyaratanPemohonResource\Pages;
use App\Filament\Resources\PersyaratanPemohonResource\RelationManagers;

class PersyaratanPemohonResource extends Resource
{
    protected static ?string $model = Perizinan::class;

    protected static ?string $pluralModelLabel = 'Persyaratan';
    protected static ?string $navigationGroup = 'Pengajuan';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('sektor.nama_sektor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_perizinan')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Lihat Berkas')
                    ->icon('heroicon-s-arrow-trending-up')
                    ->infolist([
                        TextEntry::make('persyaratan.nama_persyaratan')
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->lineClamp(2)
                            ->expandableLimitedList()
                            ->copyable()
                    ]),
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
            'index' => Pages\ListPersyaratanPemohons::route('/'),
            'create' => Pages\CreatePersyaratanPemohon::route('/create'),
            'edit' => Pages\EditPersyaratanPemohon::route('/{record}/edit'),
        ];
    }
}
