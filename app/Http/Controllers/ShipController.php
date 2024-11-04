<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ship;

class ShipController extends Controller
{
    public function index() {
        $ships = Ship::orderBy('name')->get();
        return view('main.ship', compact('ships'));
    }

    public function store(Request $request) {
        $existingShip = Ship::where('name', $request->ship)->first();

        if ($existingShip) {
            return redirect()->back()->with([
                'error' => $request->ship . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $ship = $request->ship;
            Ship::insert(['name'=> $ship]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingShip = Ship::where('id_ship', $request->id)->firstOrFail();
        $currentShip = $existingShip->name;

        if ($currentShip != $request->ship) {
            $checkShip = Ship::where('name', $request->ship)->exists();

            if ($checkShip) {
                return redirect()->back()->with([
                    'error' => $request->ship . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }

        $existingShip->update([
            'name' => $request->ship,
        ]);

        return redirect()->back();
    }
}
