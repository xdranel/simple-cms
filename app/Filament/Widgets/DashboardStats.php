<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        $posts = Post::query();

        if (!$user->isAdmin()) {
            $posts->where('user_id', $user->id);
        }

        return [
            Stat::make(
                'Total Posts',
                (clone $posts)->count()
            )
                ->description('Posts in your account')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make(
                'Published Posts',
                (clone $posts)
                    ->where('status', 'published')
                    ->count()
            )
                ->description('Posts already published')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(
                'Draft Posts',
                (clone $posts)
                    ->where('status', 'draft')
                    ->count()
            )
                ->description('Posts awaiting publication')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('warning'),

            Stat::make(
                'Featured Posts',
                (clone $posts)
                    ->where('is_featured', true)
                    ->count()
            )
                ->description('Posts marked as featured')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
        ];
    }
}
