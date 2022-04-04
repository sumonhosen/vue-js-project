@extends('back.layouts.master')
@section('title', 'Create Project')

@section('master')
<form action="{{route('back.projects.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card border-light mt-3 shadow">
                <div class="card-header">
                    <a href="{{route('back.projects.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> View All</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Project Name*</b></label>
                                <input type="text" class="form-control form-control-sm" name="name" value="{{old('name')}}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Client Name</b></label>
                                <input type="text" class="form-control form-control-sm" name="client_name" value="{{old('client_name')}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Project Duration*</b>(Days)</label>
                                <input type="number" class="form-control form-control-sm" name="duration" value="{{old('duration')}}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label><b>Client Location</b></label>
                                <input type="text" class="form-control form-control-sm" name="client_location" value="{{old('client_location')}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label><b>Assign Permission</b></label>
                                <select class="form-control" required name="user_id">
                                    <option value="" selected disabled>Select User</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><b>Project Description</b></label>

                        <textarea id="editor" class="form-control form-control-sm" name="description" cols="30" rows="3" required>{{old('description')}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="text-center">
                        <div class="img_group">
                            <img class="img-thumbnail uploaded_img" src="{{asset('img/default-img.png')}}">

                            <div class="form-group text-center">
                                <label><b>Project Image</b></label>
                                <div class="custom-file text-left">
                                    <input type="file" class="custom-file-input image_upload" name="image" accept="image/*">
                                    <label class="custom-file-label">Choose file...</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label><b>Project File</b></label>
                        <input type="file" name="file">
                        {{-- <div class="custom-file text-left">
                            <label class="custom-file-label">Choose file...</label>
                        </div> --}}
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success btn-block">Create</button>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

    <script>
        // CKEditor
        $(function () {
            CKEDITOR.replace('editor', {
                height: 400,
                filebrowserUploadUrl: "{{route('imageUpload')}}?"
            });
        });
    </script>
@endsection
