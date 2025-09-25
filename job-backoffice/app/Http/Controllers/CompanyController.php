<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public $industries=[
            'Information Technology',
            'Healthcare',
            'Finance',
            'Education',
            'Manufacturing',
            'Retail',
            'Construction',
        ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=Company::latest();
        if($request->input('archived')=='true'){
           $query->onlyTrashed();  

        } 

        $companies = $query->paginate(2)->onEachSide(1);

        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
        $industries = $this->industries;
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(CompanyCreateRequest $request)
    {
        $validatedData = $request->validated();
        // Create Owner
        $CompanyOwner = User::create([
            'name'     => $validatedData['owner_name'],
            'email'    => $validatedData['owner_email'],
            'password' => Hash::make($validatedData['owner_password']), // تشفير الباسورد
            'role'     => 'company-owner',
        ]);
      
        if (!$CompanyOwner) {
            return redirect()->route('companies.create')
                ->with('error', 'Failed to create owner.');
        }
        // Create Company
        Company::create([
            'name'     => $validatedData['name'],
            'address'  => $validatedData['address'],
            'industry' => $validatedData['industry'],
            'website'  => $validatedData['website'] ?? null,
            'ownerId'  => $CompanyOwner->id, // ربط الشركة بالـ Owner
        ]);

        return redirect()->route('companies.index')
            ->with('success', 'Company created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        //
        if($id){

            $company = Company::findOrFail($id);
        }else{

            $company = Company::where('ownerId', Auth::user()->id)->first();
        }
    
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id = null)
    {
        //
        
        $industries = $this->industries;

           //
        if($id){

            $company = Company::findOrFail($id);
        }else{

            $company = Company::where('ownerId', Auth::user()->id)->first();
        }
        return view('company.edit', compact('company','industries'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id = null)
    {
        // dd($request->all());
        $validatedData=$request->validated();
     //
        if($id){

            $company = Company::findOrFail($id);
        }else{

            $company = Company::where('ownerId', Auth::user()->id)->first();
        }
        $company->update([
            'name'     => $validatedData['name'],
            'address'  => $validatedData['address'],
            'industry' => $validatedData['industry'],
            'website'  => $validatedData['website'],
        ]); 



        $ownerData=[];
        $ownerData['name']=$validatedData['owner_name'];

        if($validatedData['owner_password']){
                 $ownerData['password']=Hash::make($validatedData['owner_password']);
        }

        $company->owner()->update(
         $ownerData
        );

        if(Auth::user()->role == 'company-owner'){
            return redirect()->route('mycompany.show',$id)
            ->with('success', 'Company updated successfully.');
        }

        if($request->query('redirectToList')=='true'){
          return redirect()->route('companies.index')
            ->with('success', 'Company updated successfully.');

        }

        return redirect()->route('companies.show',$id)
            ->with('success', 'Company updated successfully.');


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')
            ->with('success', 'Company Archived successfully.');
    }


    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index', ['archived' => 'true'])
            ->with('success', 'Company restored successfully.');
    }
}
