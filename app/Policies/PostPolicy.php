<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($ability === 'delete' || $ability === 'deleteAny'){
            return null;
        }

        return $user->role === UserRole::Admin ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAuthor();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return match ($user->role) {
            UserRole::Admin => true,
            UserRole::Author => $post->user_id === $user->id,
            default => false,
        };
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAuthor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return match ($user->role) {
            UserRole::Admin => true,
            default => $post->user_id === $user->id,
        };
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return match ($user->role) {
            UserRole::Admin => true,
            default => $post->user_id === $user->id,
        };
    }

    public function deleteAny(User $user): bool
    {
        return match ($user->role) {
            UserRole::Admin => true,
            default => false,
        };
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    public function restoreAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }
}
