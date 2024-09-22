<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = CompanyInfo::all();

        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new CompanyInfo();
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
     * @param  \App\Models\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyInfo $companyInfo)
    {
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyInfo $companyInfo)
    {
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyInfo $companyInfo)
    {
        
        $company = CompanyInfo::findOrFail($request->id);

        $company->company_name = $request->input('company_name');
        $company->representative = $request->input('representative');
        $company->establishment_date = $request->input('establishment_date');
        $company->department_name = $request->input('department_name');
        $company->post_code = $request->input('post_code');
        $company->address = $request->input('address');
        $company->business_description = $request->input('business_description');
        $company->update();

        
        return to_route('company.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyInfo $companyInfo)
    {
        $company->delete();

        return to_route('company.index');
    }
}
