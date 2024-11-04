<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desc;

class DescController extends Controller
{
    public function index() {
        $descs = Desc::orderBy('name')->get();
        return view('main.desc', compact('descs'));
    }

    public function store(Request $request) {
        $existingDesc = Desc::where('name', $request->desc)->first();

        if ($existingDesc) {
            return redirect()->back()->with([
                'error' => $request->desc . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $desc = $request->desc;
            Desc::insert(['name'=> $desc]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingDesc = Desc::where('id_desc', $request->id)->firstOrFail();
        $currentDesc = $existingDesc->name;
    
        if ($currentDesc != $request->desc) {
            $checkDesc = Desc::where('name', $request->desc)->exists();
    
            if ($checkDesc) {
                return redirect()->back()->with([
                    'error' => $request->desc . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }
    
        $existingDesc->update([
            'name' => $request->desc,
        ]);
    
        return redirect()->back();
    }
}
