<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Shipper;
use App\Models\Company;
use App\Models\Account;
use App\Models\Banker;

class CustomerController extends Controller
{
    public function index() {
        $accounts = Account::orderBy('account_no')->get();
        $bankers = Banker::orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        $shippers = Shipper::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();

        $shipperName = Shipper::pluck('name', 'id_shipper');
        $companyName = Company::pluck('name', 'id_company');
        $accountNo = Account::pluck('account_no', 'id_account');
        $bankerName = Banker::pluck('name', 'id_banker');
        return view('main.customer', compact('accounts', 'bankers', 'customers', 'shippers', 'shipperName', 'companies', 'companyName', 'accountNo', 'bankerName'));
    }

    public function store(Request $request) {
        $shipperIds = $request->id_shipper ?? [];
        $numericDiscount = preg_replace("/[^0-9]/", "", explode(",", $request->discount)[0]);
        
        $customer = Customer::updateOrCreate(
            [
                'name' => $request->customer,
                'shipper_ids' => implode(',', $shipperIds),
                'id_company' => $request->id_company,
                'id_banker' => $request->id_banker,
                'id_account' => $request->id_account,
                'discount' => $numericDiscount,
                'is_bill_weight' => $request->input_is_bill_weight
            ]
        );
    
        if ($customer->wasRecentlyCreated) {
            return redirect()->back();

        } else {
            return redirect()->back()->with([
                'error' => $request->customer . ' already exists in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
            ]);
        }
    }

    public function update(Request $request) {
        $numericEditDiscount = preg_replace("/[^0-9]/", "", explode(",", $request->discount)[0]);
        $existingCustomer = Customer::where('id_customer', $request->id)->firstOrFail();
        $currentCustomer = $existingCustomer->name;
    
        $shipperIds = null;
        if ($request->id_shipper) {
            $shipperIds = implode(',', $request->id_shipper);
        }
    
        if ($currentCustomer != $request->customer) {
            $checkCustomer = Customer::where('name', $request->customer)->exists();
    
            if ($checkCustomer) {
                return redirect()->back()->with([
                    'error' => $request->customer . ' already in the system',
                    'error_type' => 'duplicate-alert',
                    'input' => $request->all(),
                ]);

            } else {
                $existingCustomer->name = $request->customer;
                $existingCustomer->discount = $numericEditDiscount;
                $existingCustomer->id_company = $request->id_company;
                $existingCustomer->id_banker = $request->id_banker;
                $existingCustomer->id_account = $request->id_account;
                $existingCustomer->shipper_ids = $shipperIds;
                $existingCustomer->is_bill_weight = $request->value_is_bill_weight;
                $existingCustomer->save();
    
                return redirect()->back();
            }

        } else {
            $existingCustomer->discount = $numericEditDiscount;
            $existingCustomer->id_company = $request->id_company;
            $existingCustomer->id_banker = $request->id_banker;
            $existingCustomer->id_account = $request->id_account;
            $existingCustomer->shipper_ids = $shipperIds;
            $existingCustomer->is_bill_weight = $request->value_is_bill_weight;
            $existingCustomer->save();
    
            return redirect()->back();
        }
    }
}
