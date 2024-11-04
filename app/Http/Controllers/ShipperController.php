<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipper;

class ShipperController extends Controller
{
    public function index() {
        $shippers = Shipper::orderBy('name')->get();
        return view('main.shipper', compact('shippers'));
    }

    public function store(Request $request) {
        $existingShipper = Shipper::where('name', $request->shipper)->first();

        if ($existingShipper) {
            return redirect()->back()->with([
                'error' => $request->shipper . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $shipper = $request->shipper;
            Shipper::insert(['name'=> $shipper]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingShipper = Shipper::where('id_shipper', $request->id)->firstOrFail();
        $currentShipper = $existingShipper->name;
    
        if ($currentShipper != $request->shipper) {
            $checkShipper = Shipper::where('name', $request->shipper)->exists();
    
            if ($checkShipper) {
                return redirect()->back()->with([
                    'error' => $request->shipper . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }
    
        $existingShipper->update([
            'name' => $request->shipper,
        ]);
    
        return redirect()->back();
    }
    
}
