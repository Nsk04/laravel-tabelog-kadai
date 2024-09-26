<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company();
        $company->company_name = $request->input('company_name');
        $company->representative = $request->input('representative');
        $company->establishment_date = $request->input('establishment_date');
        $company->department_name = $request->input('department_name');
        $company->post_code = $request->input('post_code');
        $company->address = $request->input('address');
        $company->business_description = $request->input('business_description');
        $company->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $company = Company::findOrFail($request->id);
        $company->company_name = $request->input('company_name');
        $company->representative = $request->input('representative');
        $company->establishment_date = $request->input('establishment_date');
        $company->department_name = $request->input('department_name');
        $company->post_code = $request->input('post_code');
        $company->address = $request->input('address');
        $company->business_description = $request->input('business_description');
        $company->update();

        return to_route('companies.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return to_route('companies.index');
    }
}
