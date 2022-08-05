<?php

namespace App\Http\Controllers;

use App\DataTables\CompaniesDataTable;
use App\Models\Company;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CompaniesDataTable $companiesDataTable
     * @return Application|Factory|View
     */
    public function index(CompaniesDataTable $companiesDataTable)
    {
        return $companiesDataTable->render('components.company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = new Company();
        return view('components.company.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'photos' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('companies.create')->withErrors($validator)->withInput();
        }
        $inputs['logo_id'] = json_decode($inputs['photos'])[0];
        unset($inputs['photos']);
        Company::create($inputs);

        return redirect()->route('companies.index')->with(['success' => 'Company ' . __("messages.add")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('components.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $company->logo_id = Upload::find($company->logo_id);
        return view('components.company.edit', compact('company'));
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
        $inputs = $request->all();
        $validator = Validator::make($inputs,[
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'photos' => 'sometimes'
        ]);
        if ($validator->fails()) {
            return redirect()->route('companies.edit', $company)->withErrors($validator)->withInput();
        }
        if (isset($inputs['photos'])) {
            $inputs['logo_id'] = json_decode($inputs['photos'])[0];
            unset($inputs['photos']);
        }
        $company->update($inputs);
        return redirect()->route('companies.index')->with(['success' => 'Company ' . __("messages.update")]);
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
        return redirect()->back()->with(['success' => 'Company ' . __("messages.delete")]);
    }
}
