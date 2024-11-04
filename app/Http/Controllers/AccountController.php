<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
    public function index() {
        $accounts = Account::orderBy('account_no')->get();
        return view('main.account', compact('accounts'));
    }

    public function store(Request $request) {
        $existingAccount = Account::where('account_no', $request->account)->first();

        if ($existingAccount) {
            return redirect()->back()->with([
                'error' => $request->account . ' already in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);

        } else {

            $account = $request->account;
            Account::insert(['account_no'=> $account]);
            
            return redirect()->back();
        }
    }

    public function update(Request $request) {
        $existingAccount = Account::where('id_account', $request->id)->firstOrFail();
        $currentAccount = $existingAccount->account_no;
    
        if ($currentAccount != $request->account) {
            $checkAccount = Account::where('account_no', $request->account)->exists();
    
            if ($checkAccount) {
                return redirect()->back()->with([
                    'error' => $request->account . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);
            }
        }
        
        $existingAccount->update([
            'account_no' => $request->account,
        ]);
    
        return redirect()->back();
    }
}
