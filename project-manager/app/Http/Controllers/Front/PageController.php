<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BankCurrencyRate;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\BranchCurrencyRate;
use App\Models\Currency;

class PageController extends Controller
{
    // Homepage
    public function homepage()
    {
        return view('front.homepage');
    }

    public function branchRate(Branch $branch){
        if($branch->allow_curency_edit){
            $rates = BranchCurrencyRate::where('branch_id', $branch->id)->where('status', 1)->orderBy('position')->get();
        }else{
            $rates = BankCurrencyRate::where('bank_id', $branch->bank_id)->where('status', 1)->orderBy('position')->get();
        }

        return view('front.branchRate', compact('rates', 'branch'));
    }

    public function selectCurrencyDetails(Request $request){
        $currency = Currency::find($request->currency);

        $output = '<div class="row">';
        $output .= '<div class="col-md-6">
                        <div class="form-group">
                            <label><b>Buying Price*</b></label>
                            <input type="number" class="form-control form-control-sm" name="buying_price" value="'. ($currency->buying_price ?? '') .'" step="any" required>
                        </div>
                    </div>';
        if($request->up_down == 'Show'){
            $output .= '<div class="col-md-6">
                            <div class="form-group">
                                <label><b>Buying Price Status*</b></label>
                                <select name="buying_price_status" class="form-control form-control-sm" required>
                                    <option value="Up" '. ($currency && $currency->buying_price_status == 'Up' ? 'selected' : '') .'>Up</option>
                                    <option value="Down" '. ($currency && $currency->buying_price_status == 'Down' ? 'selected' : '') .'>Down</option>
                                </select>
                            </div>
                        </div>';
        }
        $output .= '<div class="col-md-6">
                        <div class="form-group">
                            <label><b>Selling Price*</b></label>
                            <input type="number" class="form-control form-control-sm" name="selling_price" value="'. ($currency->selling_price ?? '') .'" step="any" required>
                        </div>
                    </div>';

        if($request->up_down == 'Show'){
            $output .=  '<div class="col-md-6">
                            <div class="form-group">
                                <label><b>Selling Price Status*</b></label>
                                <select name="selling_price_status" class="form-control form-control-sm" required>
                                    <option value="Up" '. ($currency && $currency->selling_price_status == 'Up' ? 'selected' : '') .'>Up</option>
                                    <option value="Down" '. ($currency && $currency->selling_price_status == 'Down' ? 'selected' : '') .'>Down</option>
                                </select>
                            </div>
                        </div>';
        }

        $output .= '</div>';
        return $output;
    }
}
