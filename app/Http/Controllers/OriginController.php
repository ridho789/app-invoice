<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Origin;

class OriginController extends Controller
{
    public function index() {
        $origins = Origin::orderBy('name')->get();
        return view('main.origin', compact('origins'));
    }

    public function store(Request $request) {
        $existingOrigin = Origin::where('name', $request->origin)->first();

        if ($existingOrigin) {
            return redirect()->back()->with([
                'error' => $request->origin . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $origin = $request->origin;
            Origin::insert(['name'=> $origin]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingOrigin = Origin::where('id_origin', $request->id)->firstOrFail();
        $currentOrigin = $existingOrigin->name;

        if ($currentOrigin != $request->origin) {
            $checkOrigin = Origin::where('name', $request->origin)->exists();

            if ($checkOrigin) {
                return redirect()->back()->with([
                    'error' => $request->origin . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }

        $existingOrigin->update([
            'name' => $request->origin,
        ]);

        return redirect()->back();
    }
}
