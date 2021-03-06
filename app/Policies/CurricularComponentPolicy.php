<?php

namespace App\Policies;

use App\User;
use App\CurricularComponent;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurricularComponentPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any curricular components.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the curricular component.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function view(User $user, CurricularComponent $curricularComponent)
    {
        //
    }

    /**
     * Determine whether the user can create curricular components.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the curricular component.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function update(User $user, CurricularComponent $curricularComponent)
    {
        //
    }

    /**
     * Determine whether the user can delete the curricular component.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function delete(User $user, CurricularComponent $curricularComponent)
    {
        //
    }

    /**
     * Determine whether the user can restore the curricular component.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function restore(User $user, CurricularComponent $curricularComponent)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the curricular component.
     *
     * @param  \App\User  $user
     * @param  \App\CurricularComponent  $curricularComponent
     * @return mixed
     */
    public function forceDelete(User $user, CurricularComponent $curricularComponent)
    {
        //
    }
}
