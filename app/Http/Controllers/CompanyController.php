<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index() {
        $companies = Company::orderBy('name')->get();
        return view('main.company', compact('companies'));
    }

    public function store(Request $request) {
        $company = Company::updateOrCreate(
            ['name' => $request->company],
            ['shorter' => $request->shorter_company]
        );
    
        if ($company->wasRecentlyCreated) {
            return redirect()->back();

        } else {
            return redirect()->back()->with([
                'error' => $request->company . ' already exists in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);
        }
    }

    public function update(Request $request) {
        $existingCompany = Company::where('id_company', $request->id)->firstOrFail();
        $currentCompany = $existingCompany->name;
    
        if ($currentCompany != $request->company) {
            $checkCompany = Company::where('name', $request->company)->exists();
    
            if ($checkCompany) {
                return redirect()->back()->with([
                    'error' => $request->company . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);

            } else {
                $existingCompany->name = $request->company;
                $existingCompany->shorter = $request->shorter_company;
                $existingCompany->save();
    
                return redirect()->back();
            }

        } else {
            $existingCompany->shorter = $request->shorter_company;
            $existingCompany->save();
    
            return redirect()->back();
        }
    }
}
