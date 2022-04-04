@extends('back.layouts.master')
@section('title', 'Media Settings')


@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Media Settings</h5>
    </div>
    <form action="{{route('back.media.settings')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-body">
            <h3>Small</h3>
            <div class="row">
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <label>Width</label>
                        <input type="number" class="form-control form-control-sm" name="small_width" value="{{Info::Settings('media', 'small_width')}}">
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <label>Height</label>
                        <input type="number" class="form-control form-control-sm" name="small_height" value="{{Info::Settings('media', 'small_height')}}">
                    </div>
                </div>
            </div>

            <hr>

            <h3>Medium</h3>
            <div class="row">
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <label>Width</label>
                        <input type="number" class="form-control form-control-sm" name="medium_width" value="{{Info::Settings('media', 'medium_width')}}">
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <label>Height</label>
                        <input type="number" class="form-control form-control-sm" name="medium_height" value="{{Info::Settings('media', 'medium_height')}}">
                    </div>
                </div>
            </div>

            <hr>

            <h3>Large</h3>
            <div class="row">
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <label>Width</label>
                        <input type="number" class="form-control form-control-sm" name="large_width" value="{{Info::Settings('media', 'large_width')}}">
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="form-group">
                        <label>Height</label>
                        <input type="number" class="form-control form-control-sm" name="large_height" value="{{Info::Settings('media', 'large_height')}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success">Submit</button>
            <br>
            <small><b>NB: *</b> marked are required field.</small>
        </div>
    </form>
</div>
@endsection
