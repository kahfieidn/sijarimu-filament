<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Persyaratan;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PersyaratanResource\Pages;
use App\Filament\Resources\PersyaratanResource\RelationManagers;

class PersyaratanResource extends Resource
{
    protected static ?string $model = Persyaratan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'System Configuration';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Persyaratan')
                    ->schema([
                        Forms\Components\Select::make('perizinan_id')
                            ->options(fn () => \App\Models\Perizinan::pluck('nama_perizinan', 'id'))
                            ->required(),
                        Forms\Components\TextInput::make('nama_persyaratan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('deskripsi_persyaratan')
                            ->required()
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('perizinan.nama_perizinan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_persyaratan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi_persyaratan')
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
            'index' => Pages\ListPersyaratans::route('/'),
            'create' => Pages\CreatePersyaratan::route('/create'),
            'view' => Pages\ViewPersyaratan::route('/{record}'),
            'edit' => Pages\EditPersyaratan::route('/{record}/edit'),
        ];
    }
}
