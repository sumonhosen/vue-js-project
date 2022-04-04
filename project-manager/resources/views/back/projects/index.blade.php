@extends('back.layouts.master')
@section('title', 'Projects')

@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css"/>
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header">
        <h5 class="d-inline-block">Project List</h5>
        @if(Auth::user()->type=='admin')
        <a href="{{route('back.projects.create')}}" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Create new</a>
        @endif
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-sm" id="dataTable">
            <thead>
              <tr>
                <th scope="col">SL.</th>
                <th scope="col">Name</th>
                <th scope="col">Client Name</th>
                <th scope="col">Duration</th>
                <th scope="col" class="text-center" >File</th>
                <th scope="col" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($projects as $key => $project)
                    <tr>
                        <th scope="row">{{$key + 1}}</th>
                        <td>{{$project->name}}</td>
                        <td>{{$project->client_name ?? 'N/A'}}</td>
                        <td>{{$project->duration}} days</td>
                        <td class="text-center">
                            @if($project->file)
                            <a href="{{$project->file_path}}" download class="btn btn-success btn-sm"><i class="fas fa-download"></i> Download</a>
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="d-inline-block" style="width: 120px">
                                <a href="{{route('back.projects.show', $project->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                @if(Auth::user()->type=='super admin')
                                    <a href="{{route('back.projects.edit', $project->id)}}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                    <form class="d-inline-block" action="{{route('back.projects.destroy', $project->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure to remove?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js"></script>

<script>
    $(document).ready( function () {
        $('#dataTable').DataTable({
            order: [[0, "desc"]],
        });
    });
</script>
@endsection
