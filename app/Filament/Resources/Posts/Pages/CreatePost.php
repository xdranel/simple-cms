<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->extraAttributes([
                'formnovalidate' => true,
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if (!$user->isAdmin()){
            $data['user_id'] = $user->id;
            $data['status'] = 'draft';
            $data['is_featured'] = false;
        }

        $data['published_at'] =
            ($data['status'] ?? 'draft') === 'published'
                ? now()
                : null;

        return $data;
    }
}
