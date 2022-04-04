@extends('back.layouts.master')
@section('title', 'Edit Admin')

@section('master')
<form action="{{route('back.admins.update', $user->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="col-md-8">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Name*</b></label>
                                <input type="text" class="form-control form-control-sm" name="name" value="{{old('name') ?? $user->full_name}}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Email*</b></label>
                                <input type="email" class="form-control form-control-sm" name="email" value="{{old('email') ?? $user->email}}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Mobile Number*</b></label>
                                <input type="number" class="form-control form-control-sm" name="mobile_number" value="{{old('mobile_number') ?? $user->mobile_number}}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Designation*</b></label>
                                <input type="text" class="form-control form-control-sm" name="designation" value="{{old('designation') ?? $user->designation}}" required>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><b>Street*</b></label>
                                <input type="text" class="form-control form-control-sm" name="street" value="{{old('street') ?? $user->street}}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><b>Postal Code*</b></label>
                                <input type="text" class="form-control form-control-sm" name="zip" value="{{old('zip') ?? $user->zip}}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><b>City*</b></label>
                                <input type="text" class="form-control form-control-sm" name="city" value="{{old('city') ?? $user->city}}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><b>Province*</b></label>
                                <select name="state" class="form-control form-control-sm state get_shipping" required>
                                    <option value="">Select Province</option>
                                    @foreach (Info::provinces() as $province)
                                        <option value="{{$province}}" {{$province == $user->state ? 'selected' : ''}}>{{$province}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><b>Country*</b></label>
                                <input type="text" class="form-control form-control-sm" name="country" value="{{old('country') ?? $user->country}}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <div class="img_group">
                                    @if($user->profile)
                                    <img class="img-thumbnail uploaded_img" src="{{$user->profile_path}}">
                                    @else
                                    <img class="img-thumbnail uploaded_img" src="{{asset('img/default-img.png')}}">
                                    @endif

                                    <div class="form-group text-center">
                                        <label><b>Profile Picture</b></label>
                                        <div class="custom-file text-left">
                                            <input type="file" class="custom-file-input image_upload" name="profile" accept="image/*">
                                            <label class="custom-file-label">Choose file...</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Password*</b></label>
                                <input type="password" class="form-control form-control-sm" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Confirm Password*</b></label>
                                <input type="password" class="form-control form-control-sm" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button class="btn btn-success btn-block">Update</button>
                    <br>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
