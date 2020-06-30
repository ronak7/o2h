<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        $title = "Company list";
        return view('pages.company.list', compact('title', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create company";
        return view('pages.company.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'logo' => 'required|mimes:jpeg,jpg,png'
        ]);
        try {
            $path ="";
            if ($request->hasFile('logo')) {
                // Get filename with the extension
                $filenameWithExt = $request->file('logo')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('logo')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $request->file('logo')->storeAs('public/logo',$fileNameToStore);
            }

            $user_id = Auth::user()->id;
            $company = new Company();
            $company->user_id = $user_id;
            $company->name = $request->name;
            $company->email = $request->email;
            $company->logo = $path!='' ? "logo/". $fileNameToStore : '' ;
            $company->save();

            return redirect()->route('company.index')->with('status', 'company created successfully.');
        } catch (\Exception $e) {

            echo $e;
            // return redirect()->route('company.index')->with('status', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $title = "Company";
        return redirect()->route('company.show', compact('title', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $title = "Edit company";
        return view('pages.company.edit', compact('title', 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        try {

            $path = "";
            if ($request->hasFile('logo')) {
                // Get filename with the extension
                $filenameWithExt = $request->file('logo')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('logo')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $request->file('logo')->storeAs('public/logo', $fileNameToStore);
            }


            $company->name = $request->name;
            $company->email = $request->email;
            if ($request->hasFile('logo')) {
                $company->logo = "logo/" . $fileNameToStore;
            }
            $company->save();
            return redirect()->route('company.index')->with('status', 'Company has been updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('company.index')->with('status', 'Something went wrong in update.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('company.index')->with('status', 'Company has been deleted successfully.');
    }
}
