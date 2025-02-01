<?php

namespace App\Policies;

use App\Models\User;

class ModelPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }




    public function before($user , $ability){
        if ($user->super_admin) {
            return true;
        }
    }

   /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user): bool
    {
        return $user->hasAbility('products.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user , $model): bool
    {
        return $user->hasAbility('products.view') && $model->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user): bool
    {
        return $user->hasAbility('products.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user , $model): bool
    {
        return $user->hasAbility('products.update') && $model->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user , $model): bool
    {
        return $user->hasAbility('products.delete')&& $model->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore($user , $model): bool
    {
        return $user->hasAbility('products.restore')&& $model->store_id == $user->store_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete($user , $model): bool
    {
        return $user->hasAbility('products.force-delete')&& $model->store_id == $user->store_id;
    }
}

   