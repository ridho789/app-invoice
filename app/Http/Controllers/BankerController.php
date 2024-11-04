<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banker;

class BankerController extends Controller
{
    public function index() {
        $bankers = Banker::orderBy('name')->get();
        return view('main.banker', compact('bankers'));
    }

    public function store(Request $request) {
        $existingBanker = Banker::where('name', $request->banker)->first();

        if ($existingBanker) {
            return redirect()->back()->with([
                'error' => $request->banker . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $banker = $request->banker;
            Banker::insert(['name'=> $banker]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingBanker = Banker::where('id_banker', $request->id)->firstOrFail();
        $currentBanker = $existingBanker->name;
    
        if ($currentBanker != $request->banker) {
            $checkBanker = Banker::where('name', $request->banker)->exists();
    
            if ($checkBanker) {
                return redirect()->back()->with([
                    'error' => $request->banker . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }
    
        $existingBanker->update([
            'name' => $request->banker,
        ]);
    
        return redirect()->back();
    }
}
