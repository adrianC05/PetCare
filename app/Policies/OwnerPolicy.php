<?php

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Owner;

class OwnerPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Owner');
    }

    public function view(AuthUser $authUser): bool
    {
        return $authUser->can('View:Owner');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Owner');
    }

    public function update(AuthUser $authUser, Owner $owner): bool
    {
        return $authUser->can('Update:Owner');
    }

    public function delete(AuthUser $authUser, Owner $owner): bool
    {
        return $authUser->can('Delete:Owner');
    }

    public function restore(AuthUser $authUser): bool
    {
        return $authUser->can('Restore:Owner');
    }

    public function forceDelete(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDelete:Owner');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Owner');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Owner');
    }

    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:Owner');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Owner');
    }

}