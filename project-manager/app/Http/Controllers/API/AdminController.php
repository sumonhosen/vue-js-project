<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $users = User::where('type', 'admin')->get();
        return response()->json($users,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// return $request->all();
        // $v_data = [
        //     'name' => 'required|max:255',
        //     'designation' => 'required|max:255',
        //     'mobile_number' => 'required|max:255|unique:users',
        //     'email' => 'required|max:255|unique:users',
        //     'street' => 'required|max:255',
        //     'zip' => 'required|max:55',
        //     'city' => 'required|max:55',
        //     'state' => 'required|max:55',
        //     'country' => 'required|max:55',
        //     'password' => 'required|min:6|confirmed',
        // ];
        // if($request->file('profile')){
        //     $v_data['profile'] = 'mimes:jpg,png,jpeg,gif';
        // }

        // $request->validate($v_data);

        $user = new User;
        $user->type = 'admin';
        $user->last_name = $request->name;
        $user->designation = $request->designation;
        $user->mobile_number = $request->mobile_number;
        $user->email = $request->email;
        $user->street = $request->street;
        $user->zip = $request->zip;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->password = Hash::make($request->password);

        if($request->file('profile')){
            $image = $request->file('profile');
            $filename    = time() . '.' . $image->getClientOriginalExtension();

            // Resize Image 150*150
            $image_resize = Image::make($image->getRealPath());
            $image_resize->fit(150, 150);
            $image_resize->save(public_path('/uploads/user/' . $filename));

            $user->profile = $filename;
        }
        $user->save();
        return response()->json(['status'=>'success','message'=>'Successfully stored'],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        return response()->json($user,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // $v_data = [
        //     'name' => 'required|max:255',
        //     'designation' => 'required|max:255',
        //     'mobile_number' => 'required|max:255|unique:users,mobile_number,' . $id,
        //     'email' => 'required|max:255|unique:users,email,' . $id,
        //     'street' => 'required|max:255',
        //     'zip' => 'required|max:55',
        //     'city' => 'required|max:55',
        //     'state' => 'required|max:55',
        //     'country' => 'required|max:55'
        // ];
        if($request->file('profile')){
            $v_data['profile'] = 'mimes:jpg,png,jpeg,gif';
        }
        if($request->password){
            $v_data['password'] = 'min:6|confirmed';
        }

        $request->validate($v_data);

        $user = User::findOrFail($request->user_id);
        $user->last_name = $request->name;
        $user->designation = $request->designation;
        $user->mobile_number = $request->mobile_number;
        $user->email = $request->email;
        $user->street = $request->street;
        $user->zip = $request->zip;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        if($request->password){
            $user->password = Hash::make($request->password);
        }

        if($request->file('profile')){
            $image = $request->file('profile');
            $filename    = time() . '.' . $image->getClientOriginalExtension();

            // Resize Image 150*150
            $image_resize = Image::make($image->getRealPath());
            $image_resize->fit(150, 150);
            $image_resize->save(public_path('/uploads/user/' . $filename));

            // Delete old
            if($user->profile){
                $img = public_path() . '/uploads/user/' . $user->profile;
                if (file_exists($img)) {
                    unlink($img);
                }
            }

            $user->profile = $filename;
        }
        $user->save();
        return response()->json(['status'=>'success','message'=>'Successfully Updated'],200);
    }

    public function update_profile_page(){
        $user = User::where('id', Auth::user()->id)->first();
        return view('back.admin.edit-admin')->with('user', $user);
    }

    public function update_profile(Request $request){
        $v_data = [
            'name' => 'required|max:255',
            'mobile_number' => 'required|max:255',
            'email' => 'required|max:255',
            'street' => 'required|max:255',
            'zip' => 'required|max:55',
            'city' => 'required|max:55',
            'state' => 'required|max:55',
            'country' => 'required|max:55',
        ];
        if($request->file('profile')){
            $v_data['profile'] = 'mimes:jpg,png,jpeg,gif';
        }
        $request->validate($v_data);
        $user = User::findOrFail(Auth::user()->id);
        $user->last_name = $request->name;
        $user->mobile_number = $request->mobile_number;
        $user->email = $request->email;
        $user->street = $request->street;
        $user->zip = $request->zip;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;

        if($request->file('profile')){
            $image = $request->file('profile');
            $filename    = time() . '.' . $image->getClientOriginalExtension();

            // Resize Image 150*150
            $image_resize = Image::make($image->getRealPath());
            $image_resize->fit(150, 150);
            $image_resize->save(public_path('/uploads/user/' . $filename));

            if($user->profile){
                $img = public_path() . '/uploads/user/' . $user->profile;
                if (file_exists($img)) {
                    unlink($img);
                }
            }

            $user->profile = $filename;
        }
        $user->save();

        return redirect()->back()->with('success-alert', 'Profile updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      
        $user = User::findOrFail($id);
  


        // Delete Image
        if($user->image){
            $img = public_path() . '/uploads/user/' . $user->image;
            if (file_exists($img)) {
                unlink($img);
            }
        }

        $user->delete();

        return response()->json(['status'=>'success','message'=>'Successfully Deleted'],200);
    }

    public function update_password(Request $request) {
        $request->validate([
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('id', Auth::user()->id)->first();

        if(Hash::check($request->old_password, auth()->user()->password)){
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success-alert', 'Password updated successfully.');
        }
        return redirect()->back()->with('error-alert', 'Old password dose not match!');
    }
}
