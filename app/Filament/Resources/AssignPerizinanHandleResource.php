<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\AssignPerizinanHandle;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AssignPerizinanHandleResource\Pages;
use App\Filament\Resources\AssignPerizinanHandleResource\RelationManagers;

class AssignPerizinanHandleResource extends Resource
{
    protected static ?string $model = AssignPerizinanHandle::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationGroup = 'System Configuration';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Assign Perizinan')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->options(fn () => \App\Models\User::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('perizinan_id')
                            ->options(fn () => \App\Models\Perizinan::pluck('nama_perizinan', 'id'))
                            ->multiple()
                            ->searchable(),
                        Forms\Components\Toggle::make('is_all_perizinan')
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-user')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_all_perizinan')
                    ->boolean(),
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
            'index' => Pages\ListAssignPerizinanHandles::route('/'),
            'create' => Pages\CreateAssignPerizinanHandle::route('/create'),
            'view' => Pages\ViewAssignPerizinanHandle::route('/{record}'),
            'edit' => Pages\EditAssignPerizinanHandle::route('/{record}/edit'),
        ];
    }
}
