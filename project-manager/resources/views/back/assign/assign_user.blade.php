@extends('back.layouts.master')
@section('title', 'Project Details')

@section('head')
    <style>
        .comment_btn{}
        .comment_btn:hover{cursor: pointer;}
        .comment_view_btn:hover{cursor: pointer;}

        .moveContent {
        }
        .moveContent li {
            border: 1px solid #ddd;
            background: #717384;
            color: #fff;
            padding: 5px 12px;
            margin: 7px 0;
            border-radius: 3px;
            transition: .1s;
        }
        .moveContent li img {
            height: 80px;
        }
        .moveContent li:hover {
            cursor: pointer
        }
    </style>
@endsection

@section('master')
<div class="row">
    <div class="col-md-12">
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5>Project Info</h5>
            </div>
            <div class="card-body">
                <p class="mb-0"><b>Project Name:</b> {{$project->name}}</p>
                <p class="mb-0"><b>Client Name:</b> {{$project->client_name ?? 'N/A'}}</p>
                <p class="mb-0"><b>Project Duration:</b> {{$project->duration}} days</p>
                <p><b>Client Location:</b> {{$project->client_location}}</p>

                <h5>Project Description</h5>
                {!! $project->description !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card border-light m-2 shadow">
            <div class="card-header">
                <h5>Project Info</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-check form-switch" >
                        <label id=""><b>{{$project->name}}</b></label>
                        <input class="form-control" type="checkbox" id="flexSwitchCheckChecked" style="width:4%;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
