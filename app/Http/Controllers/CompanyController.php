<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyResourceCollection;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $companies = Company::where('created_by', auth()->user()->id)->limit(10)->paginate(10);
        return response()-> json(CompanyResourceCollection::make($companies),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CompanyRequest $companyRequest)
    {
        $this->authorize('create', Company::class);
        $company = Company::create($companyRequest->validated());
        return response()->json($company,201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Company $company)
    {
        $this->authorize('view', $company);
        return response()-> json(CompanyResource::make($company),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CompanyRequest $companyRequest, Company $company)
    {
        $this->authorize('update', $company);
        $company->update($companyRequest->all());
        return response()-> json($company,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);
        $company->delete();
        return response()-> json($company,200);
    }

    public function viewAllCompanies(Request $request)
    {
        $companies = Company::limit(10)->paginate(10);
        if ($request->user()->cannot('viewAny', User::class)){
            return response()->json("Access denied",403);
        }
        return response()-> json(CompanyResourceCollection::make($companies),200);
    }
}
