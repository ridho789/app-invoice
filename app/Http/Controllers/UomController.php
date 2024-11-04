<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Uom;

class UomController extends Controller
{
    public function index() {
        $uoms = Uom::orderBy('name')->get();
        return view('main.uom', compact('uoms'));
    }

    public function store(Request $request) {
        $existingUom = Uom::where('name', $request->uom)->first();

        if ($existingUom) {
            return redirect()->back()->with([
                'error' => $request->uom . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $uom = $request->uom;
            Uom::insert(['name'=> $uom]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingUom = Uom::where('id_uom', $request->id)->firstOrFail();
        $currentUom = $existingUom->name;

        if ($currentUom != $request->uom) {
            $checkUom = Uom::where('name', $request->uom)->exists();

            if ($checkUom) {
                return redirect()->back()->with([
                    'error' => $request->uom . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }

        $existingUom->update([
            'name' => $request->uom,
        ]);

        return redirect()->back();
    }
}
