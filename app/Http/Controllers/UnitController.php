<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index() {
        $units = Unit::orderBy('name')->get();
        return view('main.unit', compact('units'));
    }

    public function store(Request $request) {
        $existingUnit = Unit::where('name', $request->unit)->first();

        if ($existingUnit) {
            return redirect()->back()->with([
                'error' => $request->unit . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $unit = $request->unit;
            Unit::insert(['name'=> $unit]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingUnit = Unit::where('id_unit', $request->id)->firstOrFail();
        $currentUnit = $existingUnit->name;
    
        if ($currentUnit != $request->unit) {
            $checkUnit = Unit::where('name', $request->unit)->exists();
    
            if ($checkUnit) {
                return redirect()->back()->with([
                    'error' => $request->unit . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }
    
        $existingUnit->update([
            'name' => $request->unit,
        ]);
    
        return redirect()->back();
    }
}
