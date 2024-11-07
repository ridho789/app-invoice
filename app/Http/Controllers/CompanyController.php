<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index() {
        $companies = Company::orderBy('name')->get();
        return view('main.company', compact('companies'));
    }

    public function store(Request $request) {
        $request->validate([
            'letterhead' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $letterhead = null;

        if ($request->hasFile('letterhead')) {
            if ($request->letterhead && Storage::exists('public/' . $request->letterhead)) {
                Storage::delete('public/' . $request->letterhead);
            }

            $file = $request->file('letterhead');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('asset/assets/img/KOP', $fileName, 'public');

            if ($filePath) {
                $letterhead = $filePath;
            }
        }

        $company = Company::updateOrCreate(
            ['name' => $request->company],
            [
                'shorter' => $request->shorter_company,
                'letterhead' => $letterhead
            ]
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

        $request->validate([
            'letterhead' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $letterhead = null;
    
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

                if ($request->hasFile('letterhead')) {
                    if ($request->letterhead && Storage::exists('public/' . $request->letterhead)) {
                        Storage::delete('public/' . $request->letterhead);
                    }
        
                    $file = $request->file('letterhead');
                    $fileName = $file->getClientOriginalName();
                    $filePath = $file->storeAs('asset/assets/img/KOP', $fileName, 'public');
        
                    if ($filePath) {
                        $letterhead = $filePath;
                    }

                    $existingCompany->letterhead = $letterhead;
                }
                
                $existingCompany->save();
                return redirect()->back();
            }

        } else {
            $existingCompany->shorter = $request->shorter_company;

            if ($request->hasFile('letterhead')) {
                if ($request->letterhead && Storage::exists('public/' . $request->letterhead)) {
                    Storage::delete('public/' . $request->letterhead);
                }
    
                $file = $request->file('letterhead');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('asset/assets/img/KOP', $fileName, 'public');
    
                if ($filePath) {
                    $letterhead = $filePath;
                }
                
                $existingCompany->letterhead = $letterhead;
            }

            $existingCompany->save();
            return redirect()->back();
        }
    }
}
