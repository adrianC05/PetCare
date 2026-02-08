<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Mascot;
use Illuminate\Auth\Access\HandlesAuthorization;

class MascotPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Mascot');
    }

    public function view(AuthUser $authUser, Mascot $mascot): bool
    {
        return $authUser->can('View:Mascot');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Mascot');
    }

    public function update(AuthUser $authUser, Mascot $mascot): bool
    {
        return $authUser->can('Update:Mascot');
    }

    public function delete(AuthUser $authUser, Mascot $mascot): bool
    {
        return $authUser->can('Delete:Mascot');
    }

    public function restore(AuthUser $authUser, Mascot $mascot): bool
    {
        return $authUser->can('Restore:Mascot');
    }

    public function forceDelete(AuthUser $authUser, Mascot $mascot): bool
    {
        return $authUser->can('ForceDelete:Mascot');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Mascot');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Mascot');
    }

    public function replicate(AuthUser $authUser, Mascot $mascot): bool
    {
        return $authUser->can('Replicate:Mascot');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Mascot');
    }

}