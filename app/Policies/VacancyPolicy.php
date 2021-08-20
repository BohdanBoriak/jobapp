<?php

namespace App\Policies;

use App\Http\Requests\BookingRequest;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
{
    use HandlesAuthorization;

    public function before(User $user){
        if($user->role == 'admin'){
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Vacancy $vacancy)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role == 'employer';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Vacancy $vacancy)
    {
        return $vacancy->created_by_user == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vacancy  $vacancy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Vacancy $vacancy)
    {
        return $vacancy->created_by_user == $user->id;
    }

    public function book(User $user)
    {
        if($user->role == 'worker'){
            return true;
        }
    }

    public function info(User $user, Vacancy $vacancy)
    {
        return $vacancy->created_by_user == $user->id;
    }
}
