<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Requests\VacancyRequest;
use App\Http\Resources\UserResourceCollection;
use App\Http\Resources\VacancyResource;
use App\Http\Resources\VacancyResourceCollection;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request['only_active']) {
            $vacancies = Vacancy::has('userThatBooked','<',DB::raw('vacancies.amount'))->paginate(10);
        } else {
            $vacancies = Vacancy::limit(10)->paginate();
        }
        return response()->json(VacancyResourceCollection::make($vacancies), 200);

//        an old version

//        $vacancies = Vacancy::limit(10)->paginate();
//        $vacancies = Vacancy::limit(10)->get();

//        $vacancies = Vacancy::all();
//        dd($vacancies);
//        if ($request['only_active']) {
//            $filtered_vacancies = $vacancies->filter(function ($vacancy, $key) {
//                return $vacancy['amount'] > DB::table('vacancies_booked_by_users')->where('vacancy_id', $vacancy['id'])->count();
//            })->values();
////            dd($filtered_vacancies);
//            return response()->json(VacancyResourceCollection::make($filtered_vacancies), 200);
//        } else {
//            return response()->json(VacancyResourceCollection::make($vacancies), 200);
//        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(VacancyRequest $vacancyRequest)
    {
        $this->authorize('create', Vacancy::class);
        $vacancy = Vacancy::create($vacancyRequest->validated());
        return response()->json($vacancy, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Vacancy $vacancy
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Vacancy $vacancy)
    {
        return response()->json(VacancyResource::make($vacancy), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Vacancy $vacancy
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(VacancyRequest $vacancyRequest, Vacancy $vacancy)
    {
        $this->authorize('update', $vacancy);
        $vacancy->update($vacancyRequest->all());
        return response()->json($vacancy, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Vacancy $vacancy
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Vacancy $vacancy)
    {
        $this->authorize('delete', $vacancy);
        $vacancy->delete();
        return response()->json($vacancy, 200);
    }

    public function book(BookingRequest $bookingRequest, Vacancy $vacancy)
    {
        $this->authorize('book', $vacancy);
        $request = $bookingRequest->validated();
        $user_id = $request['user_id'];
        $vacancy_id = $request['vacancy_id'];
        $check_if_exists = DB::table('vacancies_booked_by_users')->where('user_id', $user_id)->where('vacancy_id', $vacancy_id)->first();
        if ($check_if_exists != null) {
            return response()->json('You have already signed on this vacancy', 200);
        } else {
            $vacancy = Vacancy::find($vacancy_id);
            $vacancy->userThatBooked()->attach($user_id);
            return response()->json('You have successfully signed on the vacancy ', 200);
        }
    }

    public function unbook(BookingRequest $bookingRequest, Vacancy $vacancy)
    {
        $this->authorize('book', $vacancy);
        $request = $bookingRequest->validated();
        $user_id = $request['user_id'];
        $vacancy_id = $request['vacancy_id'];
        $check_if_exists = DB::table('vacancies_booked_by_users')->where('user_id', $user_id)->where('vacancy_id', $vacancy_id)->first();
        if ($check_if_exists != null) {
            $vacancy = Vacancy::find($vacancy_id);
            $vacancy->userThatBooked()->detach($user_id);
            return response()->json('You have successfully unsigned from the vacancy ', 200);
        } else {
            return response()->json('You have not signed on this vacancy', 200);
        }
    }

    public function workersForSingleVacancy(Vacancy $vacancy){
        $this->authorize('info', $vacancy);
        $users = User::has('bookedVacancy','=',$vacancy->id)->paginate(10);
        return response()-> json(UserResourceCollection::make($users),200);
    }
}
