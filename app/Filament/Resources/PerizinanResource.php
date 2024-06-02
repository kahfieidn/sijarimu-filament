<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerizinanResource\Pages;
use App\Filament\Resources\PerizinanResource\RelationManagers;
use App\Models\Perizinan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerizinanResource extends Resource
{
    protected static ?string $model = Perizinan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Administrator';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sektor_id')
                    ->options(fn () => \App\Models\Sektor::pluck('nama_sektor', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('nama_perizinan')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\Select::make('perizinan_life_cycle_id')
                //     ->options(fn () => \App\Models\PerizinanLifecycle::pluck('flow', 'id'))
                //     ->required(),
                Forms\Components\Select::make('perizinan_lifecycle_id')
                    ->options(fn () => \App\Models\PerizinanLifecycle::pluck('nama_flow', 'id'))
                    ->required(),

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
            'index' => Pages\ListPerizinans::route('/'),
            'create' => Pages\CreatePerizinan::route('/create'),
            'view' => Pages\ViewPerizinan::route('/{record}'),
            'edit' => Pages\EditPerizinan::route('/{record}/edit'),
        ];
    }
}
