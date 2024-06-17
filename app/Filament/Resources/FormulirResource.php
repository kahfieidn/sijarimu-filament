<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Formulir;
use Filament\Forms\Form;
use App\Models\Perizinan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FormulirResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FormulirResource\RelationManagers;

class FormulirResource extends Resource
{
    protected static ?string $model = Formulir::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?string $navigationGroup = 'System Configuration';

    protected static ?int $navigationSort = 4;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('perizinan_id')
                    ->options(Perizinan::all()->pluck('nama_perizinan', 'id')->toArray())
                    ->required(),
                Forms\Components\TextInput::make('nama_formulir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        'string' => 'String',
                        'date' => 'Date',
                        'select' => 'Select',
                    ]),
                Forms\Components\Select::make('role_id')
                    ->options(Role::all()->pluck('name', 'id')->toArray()),
                Repeater::make('options')
                    ->schema([
                        Forms\Components\TextInput::make('value'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('perizinan.nama_perizinan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_formulir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
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
            'index' => Pages\ListFormulirs::route('/'),
            'create' => Pages\CreateFormulir::route('/create'),
            'view' => Pages\ViewFormulir::route('/{record}'),
            'edit' => Pages\EditFormulir::route('/{record}/edit'),
        ];
    }
}
