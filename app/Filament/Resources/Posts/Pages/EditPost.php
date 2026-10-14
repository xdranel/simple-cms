<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = auth()->user();
        $post = $this->getRecord();

        if (!$user->isAdmin()) {
            $data['user_id'] = $post->user_id;
            $data['status'] = $post->status;
            $data['is_featured'] = $post->is_featured;
        }

        $oldStatus = $post->status;
        $newStatus = $data['status'];

        if ($oldStatus !== 'published' && $newStatus === 'published') {
            $data['published_at'] = now();
        } elseif ($newStatus === 'draft') {
            $data['published_at'] = null;
        } else {
            $data['published_at'] = $post->published_at;
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return self::getResource()::getUrl('index');
    }
}
