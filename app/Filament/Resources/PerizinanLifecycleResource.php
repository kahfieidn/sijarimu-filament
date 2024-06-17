<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StatusPermohonan;
use Filament\Resources\Resource;
use App\Models\PerizinanLifecycle;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PerizinanLifecycleResource\Pages;
use App\Filament\Resources\PerizinanLifecycleResource\RelationManagers;
use App\Models\Feature;

class PerizinanLifecycleResource extends Resource
{
    protected static ?string $model = PerizinanLifecycle::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $navigationGroup = 'Master Configuration';

    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Flow')
                    ->schema([
                        Forms\Components\TextInput::make('nama_flow')
                            ->required()
                            ->maxLength(255),
                        Repeater::make('flow')
                            ->schema([
                                Select::make('flow')
                                    ->options(Feature::all()->pluck('nama_feature', 'nama_feature')->toArray()) // Menggunakan 'nama_feature' sebagai kunci dan label
                                    ->searchable()
                                    ->required(),
                                Select::make('role_id')
                                    ->options(Role::all()->pluck('name', 'id')->toArray())
                                    ->multiple()
                                    ->searchable()
                                    ->required(),
                            ]),
                    ]),
                Section::make('Detail Flow Status')
                    ->schema([
                        Repeater::make('flow_status')
                            ->schema([
                                Select::make('role')
                                    ->options(Role::all()->pluck('name', 'id')->toArray())
                                    ->required(),
                                Select::make('status')
                                    ->options(StatusPermohonan::pluck('nama_status', 'id')->toArray())
                                    ->multiple()
                                    ->required(),
                                Select::make('condition_status')
                                    ->options(StatusPermohonan::pluck('nama_status', 'id')->toArray())
                                    ->searchable(),
                                Select::make('default_status')
                                    ->options(StatusPermohonan::pluck('nama_status', 'id')->toArray())
                                    ->searchable()
                                    ->required(),
                            ])
                            ->cloneable()
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_flow')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListPerizinanLifecycles::route('/'),
            'create' => Pages\CreatePerizinanLifecycle::route('/create'),
            'view' => Pages\ViewPerizinanLifecycle::route('/{record}'),
            'edit' => Pages\EditPerizinanLifecycle::route('/{record}/edit'),
        ];
    }
}
