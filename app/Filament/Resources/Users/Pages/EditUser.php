<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use App\Models\User;
use Filament\Resources\Pages\EditRecord;use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $target = $this->getRecord();

        if ($target->id === auth()->id()){
            $data['role'] = $target->role;
        }

        if ($target->isAdmin() && ($data['role'] ?? $target->role) !== 'admin' &&
            User::where('role', 'admin')->count() <= 1) {
            throw ValidationException::withMessages([
                'role' => 'The last admin cannot be demoted.',
            ]);
        }

        return $data;
    }
}
