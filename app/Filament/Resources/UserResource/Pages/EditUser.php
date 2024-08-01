<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['nomor_hp'] = '62' . $data['nomor_hp'];
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['password'] === null) {
            $data['password'] = $this->record->password;
        }

        return $data;
    }


}
