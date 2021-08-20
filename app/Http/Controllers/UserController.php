<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::limit(10)->paginate();
        if ($request->user()->cannot('viewAny', User::class)){
            return response()->json("Access denied",403);
        }
            return response()-> json(UserResourceCollection::make($users),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // registration performs this action
//    public function store(Request $request)
//    {
//
//    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, User $user)
    {
        if ($request->user()->cannot('view', $user)){
            return response()->json("Access denied",403);
        }
        return response()->json(UserResource::make($user),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $userRequest
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $userRequest, User $user)
    {
        $this->authorize('update', $user);
        $user->update($userRequest->all());
        return response()-> json($user,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->cannot('delete', $user)){
            return response()->json("Access denied",403);
        }
        $user->delete();
        return response()-> json($user,200);
    }
}
