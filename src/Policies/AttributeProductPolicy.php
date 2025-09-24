<?php

namespace Mortezaa97\Shop\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Mortezaa97\Shop\Models\AttributeProduct;

class AttributeProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AttributeProduct $attributeProduct): bool
    {
        return $user->id === $attributeProduct->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AttributeProduct $attributeProduct): bool
    {
        return $user->id === $attributeProduct->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AttributeProduct $attributeProduct): bool
    {
        return $user->id === $attributeProduct->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AttributeProduct $attributeProduct): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AttributeProduct $attributeProduct): bool
    {
        return $user->hasRole('admin');
    }
}
