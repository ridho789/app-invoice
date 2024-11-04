<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    public function index() {
        $states = State::orderBy('name')->get();
        return view('main.state', compact('states'));
    }

    public function store(Request $request) {
        $existingState = State::where('name', $request->state)->first();

        if ($existingState) {
            return redirect()->back()->with([
                'error' => $request->state . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $state = $request->state;
            State::insert(['name'=> $state]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingState = State::where('id_state', $request->id)->firstOrFail();
        $currentState = $existingState->name;

        if ($currentState != $request->state) {
            $checkState = State::where('name', $request->state)->exists();

            if ($checkState) {
                return redirect()->back()->with([
                    'error' => $request->state . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }

        $existingState->update([
            'name' => $request->state,
        ]);

        return redirect()->back();
    }
}
