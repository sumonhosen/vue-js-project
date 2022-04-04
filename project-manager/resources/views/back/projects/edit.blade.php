@extends('back.layouts.master')
@section('title', 'Edit Project')

@section('master')
<div class="card">
    <div class="card-header">
        <a href="{{route('back.projects.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> View All</a>
        <a href="{{route('back.projects.create')}}" class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Create</a>
        <a href="{{route('back.projects.show', $project->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>

        <form class="d-inline-block" action="{{route('back.projects.destroy', $project->id)}}" method="POST">
            @method('DELETE')
            @csrf

            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i> Delete</button>
        </form>

        @if($project->file)
        <a href="{{$project->file_path}}" download class="btn btn-success btn-sm"><i class="fas fa-download"></i> Download file</a>
        @endif
    </div>
</div>

<form action="{{route('back.projects.update', $project->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="col-md-8">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Project Name*</b></label>
                                <input type="text" class="form-control form-control-sm" name="name" value="{{old('name') ?? $project->name}}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Client Name</b></label>
                                <input type="text" class="form-control form-control-sm" name="client_name" value="{{old('client_name') ?? $project->client_name}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Project Duration*</b>(Days)</label>
                                <input type="number" class="form-control form-control-sm" name="duration" value="{{old('duration') ?? $project->duration}}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label><b>Client Location</b></label>
                                <input type="text" class="form-control form-control-sm" name="client_location" value="{{old('client_location') ?? $project->client_location}}">
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

                        <textarea id="editor" class="form-control form-control-sm" name="description" cols="30" rows="3" required>{{old('description') ?? $project->description}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-light mt-3 shadow">
                <div class="card-body">
                    <div class="text-center">
                        <div class="img_group">
                            <img class="img-thumbnail uploaded_img" src="{{$project->img_paths['medium']}}">

                            @if($project->media_id)
                            <a href="{{route('back.projects.removeImage', $project->id)}}" onclick="return confirm('Are you sure to remove?');" class="btn btn-sm btn-danger remove_image" title="Remove image"><i class="fas fa-times"></i></a>
                            @endif

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
                        <label><b>Update Project File</b></label>
                        <input type="file" name="file">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success btn-block">Update</button>
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
