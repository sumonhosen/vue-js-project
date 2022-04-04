<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckBranchCurrencyOption;
use App\Models\Branch;
use App\Models\BranchCurrencyRate;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BranchPanelController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest:branch')->only('login', 'loginSubmit');
        $this->middleware(CheckBranchCurrencyOption::class)->only('currencies', 'currenciesCreate', 'currenciesStore');
    }

    // login
    public function login(){
        return view('branch.login');
    }
    public function loginSubmit(Request $request){
        $auth = auth('branch')->attempt(['username' => $request->email, 'password' => $request->password]);
        if (!$auth) {
            return redirect()->back()->withInput()->with('error-alert', 'Email or Password Wrong!');
        }

        return redirect()->intended(route('branch.dashboard'));
    }
    public function logout(){
        auth('branch')->logout();

        return redirect()->route('homepage');
    }

    public function dashboard(){
        return view('branch.dashboard');
    }

    public function profile(){
        return view('branch.profile');
    }
    public function updateProfile(Request $request){
        $branch = Branch::findOrFail(auth('branch')->user()->id);

        if($request->request_type == 'password'){
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed'
            ]);

            if(!Hash::check($request->current_password, $branch->password)){
                return redirect()->back()->with('error-alert', 'Current password does not match!');
            }
            $branch->password = Hash::make($request->password);
            $branch->save();

            return redirect()->back()->with('success-alert', 'Password changed successfully.');
        }

        $v_data['name'] = 'required|max:255';
        $v_data['username'] = 'required|max:60|unique:branches,username,' . $branch->id;

        $request->validate($v_data);

        $branch->name = $request->name;
        $branch->code = $request->code;
        $branch->display_scrolling_text = $request->display_scrolling_text;
        $branch->username = $request->username;
        $branch->address = $request->address;
        $branch->save();

        return redirect()->back()->with('success-alert', 'Profile updated successfully.');
    }

    public function currencies(){
        $histories = BranchCurrencyRate::where('branch_id', auth('branch')->user()->id)->get();
        $active_rates = BranchCurrencyRate::where('status', 1)->where('branch_id', auth('branch')->user()->id)->orderBy('position')->get();

        return view('branch.currencies', compact('histories', 'active_rates'));
    }
    public function currenciesCreate(){
        $currencies = Currency::orderBy('name')->get();

        return view('branch.currenciesCreate', compact('currencies'));
    }
    public function currenciesStore(Request $request){
        $request->validate([
            'currency' => 'required',
            'buying_price' => 'required',
            // 'buying_price_status' => 'required',
            'selling_price' => 'required',
            // 'selling_price_status' => 'required',
        ]);

        // Update Old
        DB::table('branch_currency_rates')->where('currency_id', $request->currency)->where('branch_id', auth('branch')->user()->id)->where('status', 1)->update([
            'status' => 2
        ]);

        $currency = Currency::find($request->currency);

        $bank_currency_rate = new BranchCurrencyRate;
        $bank_currency_rate->currency_id = $request->currency;
        $bank_currency_rate->currency_name = $currency->name;
        $bank_currency_rate->branch_id = auth('branch')->user()->id;
        $bank_currency_rate->buying_price = $request->buying_price;
        $bank_currency_rate->buying_price_status = $request->buying_price_status;
        $bank_currency_rate->selling_price = $request->selling_price;
        $bank_currency_rate->selling_price_status = $request->selling_price_status;
        $bank_currency_rate->save();

        return redirect()->back()->with('success-alert', 'Rate addedd successfully.');
    }

    public function currenciesPosition(Request $request){
        foreach((array)$request->position as $key => $position){
            $rate = BranchCurrencyRate::find($position);
            $rate->position = $key;
            $rate->save();
        }

        return redirect()->back()->with('success-alert', 'Position updated successfully.');
    }
}
