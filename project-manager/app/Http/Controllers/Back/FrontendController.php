<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    // General
    public function general(){
        return view('back.frontend.general');
    }

    public function generalStore(Request $request){
        // $request->validate([
        //     'title' => 'required|max:255',
        //     'slogan' => 'required|max:255',
        //     'mobile_number' => 'required|max:255',
        //     'email' => 'required|max:255',
        //     'city' => 'required|max:255',
        //     'province' => 'required|max:255',
        //     'postal_code' => 'required|max:255',
        //     'street' => 'required|max:255',
        //     // 'tax_type' => 'required|max:255',
        //     'copyright' => 'required|max:255',
        // ]);

        $where = array();
        $where['group'] = 'general';

        $where['name'] = 'display_scrolling_text';
        $insert['value'] = $request->display_scrolling_text;
        DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'slogan';
        // $insert['value'] = $request->slogan;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'mobile_number';
        // $insert['value'] = $request->mobile_number;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'email';
        // $insert['value'] = $request->email;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'tel';
        // $insert['value'] = $request->tel;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'copyright';
        // $insert['value'] = $request->copyright;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'city';
        // $insert['value'] = $request->city;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'state';
        // $insert['value'] = $request->province;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'country';
        // $insert['value'] = $request->country;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'zip';
        // $insert['value'] = $request->postal_code;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'street';
        // $insert['value'] = $request->street;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'tax';
        // $insert['value'] = $request->tax;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'tax_type';
        // $insert['value'] = $request->tax_type;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'currency_name';
        // $insert['value'] = $request->currency_name;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'currency_symbol';
        // $insert['value'] = $request->currency_symbol;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // // $where['name'] = 'shipping_charge';
        // // $insert['value'] = $request->shipping_charge;
        // // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'meta_description';
        // $insert['value'] = $request->meta_description;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'keywords';
        // $insert['value'] = $request->keywords;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // // Update Logo
        // if($request->logo){
        //     $this->validate($request, [
        //         'logo' => 'image|mimes:jpg,png,jpeg,gif'
        //     ]);

        //     // Delete Old
        //     if(\Info::Settings('general', 'logo')){
        //         $img_del = public_path('/uploads/info/' . \Info::Settings('general', 'logo'));
        //         if (file_exists($img_del)) {
        //             unset($photo);
        //             unlink($img_del);
        //         }
        //     }

        //     $file = $request->file('logo');
        //     $photo = 'logo.' . $file->getClientOriginalExtension();
        //     $destination = public_path() . '/uploads/info';
        //     $file->move($destination, $photo);

        //     // Store logo
        //     $where['name'] = 'logo';
        //     $insert['value'] = $photo;
        //     DB::table('settings')->updateOrInsert($where, $insert);
        // }

        // // Update Favicon
        // if($request->favicon){
        //     $this->validate($request, [
        //         'favicon' => 'image|mimes:jpg,png,jpeg,gif'
        //     ]);

        //     // Delete Old
        //     if(\Info::Settings('general', 'favicon')){
        //         $img_del = public_path('/uploads/info/' . \Info::Settings('general', 'favicon'));
        //         if (file_exists($img_del)) {
        //             unset($photo);
        //             unlink($img_del);
        //         }
        //     }

        //     $file = $request->file('favicon');
        //     $photo = 'favicon.' . $file->getClientOriginalExtension();
        //     $destination = public_path() . '/uploads/info';
        //     $file->move($destination, $photo);

        //     // Store Favicon
        //     $where['name'] = 'favicon';
        //     $insert['value'] = $photo;
        //     DB::table('settings')->updateOrInsert($where, $insert);
        // }

        // // Update OG
        // if($request->og_image){
        //     $this->validate($request, [
        //         'og_image' => 'image|mimes:jpg,png,jpeg,gif'
        //     ]);

        //     // Delete Old
        //     if(\Info::Settings('general', 'og_image')){
        //         $img_del = public_path('/uploads/info/' . \Info::Settings('general', 'og_image'));
        //         if (file_exists($img_del)) {
        //             unset($photo);
        //             unlink($img_del);
        //         }
        //     }

        //     $file = $request->file('og_image');
        //     $photo = 'og_image.' . $file->getClientOriginalExtension();
        //     $destination = public_path() . '/uploads/info';
        //     $file->move($destination, $photo);

        //     // Store og_image
        //     $where['name'] = 'og_image';
        //     $insert['value'] = $photo;
        //     DB::table('settings')->updateOrInsert($where, $insert);
        // }

        // // Home Banner
        // $where['group'] = 'home_banner';

        // $where['name'] = 'title_text_1';
        // $insert['value'] = $request->hb_title_text_1;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'title_text_2';
        // $insert['value'] = $request->hb_title_text_2;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'short_description';
        // $insert['value'] = $request->hb_short_description;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'button_text';
        // $insert['value'] = $request->hb_button_text;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'button_url';
        // $insert['value'] = $request->hb_button_url;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // if($request->hb_background){
        //     $this->validate($request, [
        //         'hb_background' => 'image|mimes:jpg,png,jpeg,gif'
        //     ]);

        //     // Delete Old
        //     if(\Info::Settings('home_banner', 'background')){
        //         $img_del = public_path('/uploads/info/' . \Info::Settings('home_banner', 'background'));
        //         if (file_exists($img_del)) {
        //             unset($photo);
        //             unlink($img_del);
        //         }
        //     }

        //     $file = $request->file('hb_background');
        //     $photo = 'hb_background.' . $file->getClientOriginalExtension();
        //     $destination = public_path() . '/uploads/info';
        //     $file->move($destination, $photo);

        //     // Store og_image
        //     $where['name'] = 'background';
        //     $insert['value'] = $photo;
        //     DB::table('settings')->updateOrInsert($where, $insert);
        // }

        // // Social Links
        // $where['group'] = 'social';

        // $where['name'] = 'facebook';
        // $insert['value'] = $request->facebook;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'twitter';
        // $insert['value'] = $request->twitter;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'youtube';
        // $insert['value'] = $request->youtube;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'instagram';
        // $insert['value'] = $request->instagram;
        // DB::table('settings')->updateOrInsert($where, $insert);

        // $where['name'] = 'linkedin';
        // $insert['value'] = $request->linkedin;
        // DB::table('settings')->updateOrInsert($where, $insert);

        return redirect()->back()->with('success-alert', 'Information updated successfully.');
    }
}
