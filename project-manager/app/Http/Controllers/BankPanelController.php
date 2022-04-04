<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankCurrencyRate;
use App\Models\Branch;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BankPanelController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest:bank')->only('login', 'loginSubmit');
        // $this->middleware(CheckBankCurrencyOption::class)->only('currencies', 'currenciesCreate', 'currenciesStore');
    }

    public function login(){
        return view('bank.login');
    }
    public function loginSubmit(Request $request){
        $auth = auth('bank')->attempt(['username' => $request->email, 'password' => $request->password]);
        if (!$auth) {
            return redirect()->back()->withInput()->with('error-alert', 'Email or Password Wrong!');
        }

        return redirect()->intended(route('bank.dashboard'));
    }
    public function logout(){
        auth('bank')->logout();

        return redirect()->route('homepage');
    }

    // Dashboard
    public function dashboard(){
        return view('bank.dashboard');
    }
    public function profile(){
        return view('bank.profile');
    }
    public function updateProfile(Request $request){
        $bank = Bank::findOrFail(auth('bank')->user()->id);

        if($request->request_type == 'password'){
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed'
            ]);

            if(!Hash::check($request->current_password, $bank->password)){
                return redirect()->back()->with('error-alert', 'Current password does not match!');
            }
            $bank->password = Hash::make($request->password);
            $bank->save();

            return redirect()->back()->with('success-alert', 'Password changed successfully.');
        }

        $v_data['name'] = 'required|max:255';
        $v_data['number_of_decimal'] = 'required';
        $v_data['up_down_arrow'] = 'required';
        $v_data['username'] = 'required|max:60|unique:banks,username,' . $bank->id;

        $request->validate($v_data);

        $bank->name = $request->name;
        $bank->number_of_decimal = $request->number_of_decimal;
        $bank->up_down_arrow = $request->up_down_arrow;

        if($request->file('logo')){
            $this->validate($request, [
                'logo' => 'image|mimes:jpg,png,jpeg,gif'
            ]);
            $file = $request->file('logo');
            $photo = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/bank';
            $file->move($destination, $photo);

            // Delete Image
            if ($bank->logo){
                $img_del = public_path() . '/uploads/bank/' . $bank->logo;
                if (file_exists($img_del)) {
                    unlink($img_del);
                }
            }

            $bank->logo = $photo;
        }

        $bank->username = $request->username;
        $bank->save();

        return redirect()->back()->with('success-alert', 'Profile updated successfully.');
    }
    public function removeLogo(Bank $bank){
        // Delete Image
        if ($bank->logo){
            $img_del = public_path() . '/uploads/bank/' . $bank->logo;
            if (file_exists($img_del)) {
                unlink($img_del);
            }
        }
        $bank->logo = null;
        $bank->save();

        return redirect()->back()->with('success-alert', 'Bank logo deleted successfully.');
    }

    public function branches(){
        $branches = Branch::where('bank_id', auth('bank')->user()->id)->get();
        return view('bank.branches', compact('branches'));
    }
    public function branchesCreate(){
        return view('bank.branchesCreate');
    }
    public function branchesStore(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:60|unique:branches',
            'code' => 'required|max:255',
            'allow_curency_edit' => 'required',
            'address' => 'max:255',
            'password' => 'required|min:8|confirmed'
        ]);

        // dd(auth('bank')->user()->id);

        $branch = new Branch;
        $branch->name = $request->name;
        $branch->allow_curency_edit = $request->allow_curency_edit;
        $branch->code = $request->code;
        $branch->bank_id = auth('bank')->user()->id;
        $branch->username = $request->username;
        $branch->address = $request->address;
        $branch->password = Hash::make($request->password);
        $branch->save();

        return redirect()->back()->with('success-alert', 'Branch created successfully.');
    }
    public function branchesEdit($id){
        $branch = Branch::where('bank_id', auth('bank')->user()->id)->findOrFail($id);

        return view('bank.branchesEdit', compact('branch'));
    }
    public function branchesUpdate(Request $request, $id){
        $branch = Branch::where('bank_id', auth('bank')->user()->id)->findOrFail($id);

        if($request->request_type == 'password'){
            $request->validate([
                'password' => 'required|min:8|confirmed'
            ]);
            $branch->password = Hash::make($request->password);
            $branch->save();

            return redirect()->back()->with('success-alert', 'Password changed successfully.');
        }

        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:60|unique:branches,username,' . $id,
            'code' => 'required|max:255',
            'allow_curency_edit' => 'required',
            'address' => 'max:255'
        ]);

        $branch->name = $request->name;
        $branch->allow_curency_edit = $request->allow_curency_edit;
        $branch->code = $request->code;
        $branch->bank_id = auth('bank')->user()->id;
        $branch->username = $request->username;
        $branch->address = $request->address;
        $branch->save();

        return redirect()->back()->with('success-alert', 'Branch updated successfully.');
    }
    public function branchesDelete($id){
        $branch = Branch::where('bank_id', auth('bank')->user()->id)->findOrFail($id);
        $branch->delete();

        return redirect()->back()->with('success-alert', 'Branch deleted successfully.');
    }

    public function currencies(){
        $histories = BankCurrencyRate::where('bank_id', auth('bank')->user()->id)->get();
        $active_rates = BankCurrencyRate::where('status', 1)->where('bank_id', auth('bank')->user()->id)->orderBy('position')->get();

        return view('bank.currencies', compact('histories', 'active_rates'));
    }
    public function currenciesCreate(){
        $currencies = Currency::orderBy('name')->get();

        return view('bank.currenciesCreate', compact('currencies'));
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
        DB::table('bank_currency_rates')->where('currency_id', $request->currency)->where('bank_id', auth('bank')->user()->id)->where('status', 1)->update([
            'status' => 2
        ]);

        $currency = Currency::find($request->currency);

        $bank_currency_rate = new BankCurrencyRate;
        $bank_currency_rate->currency_id = $request->currency;
        $bank_currency_rate->currency_name = $currency->name;
        $bank_currency_rate->bank_id = auth('bank')->user()->id;
        $bank_currency_rate->buying_price = $request->buying_price;
        $bank_currency_rate->buying_price_status = $request->buying_price_status;
        $bank_currency_rate->selling_price = $request->selling_price;
        $bank_currency_rate->selling_price_status = $request->selling_price_status;
        $bank_currency_rate->save();

        return redirect()->back()->with('success-alert', 'Rate addedd successfully.');
    }

    public function currenciesPosition(Request $request){
        foreach((array)$request->position as $key => $position){
            $rate = BankCurrencyRate::find($position);
            $rate->position = $key;
            $rate->save();
        }

        return redirect()->back()->with('success-alert', 'Position updated successfully.');
    }
}
