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
<div class="card">
    <div class="card-header">
        <a href="{{route('back.projects.index')}}" class="btn btn-success btn-sm"><i class="fas fa-angle-double-left"></i> View All</a>
        <a href="{{route('back.projects.create')}}" class="btn btn-info btn-sm"><i class="fas fa-plus"></i> Create</a>
        <a href="{{route('back.projects.edit', $project->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>

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

<div class="row">
    <div class="col-md-8">
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
    <div class="col-md-4">
        @if($project->status < 4)
        <div class="card border-light mt-3 shadow">
            <div class="card-header">
                <h5>Create Section</h5>
            </div>

            <form action="{{route('back.projects.sectionCreate', $project->id)}}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label><b>Section Name</b>*</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                    </div>
                    {{-- <div class="form-group">
                        <label><b>Section Note</b></label>
                        <textarea name="note" class="form-control" cols="30" rows="5">{{old('note')}}</textarea>
                    </div> --}}

                    <div class="form-group">
                        <label><b>Group*</b></label>
                        <select name="group" class="form-control">
                            <option value="Front End">Front End</option>
                            <option value="Back End">Back End</option>
                        </select>
                    </div>

                    <div class="item_group">
                        <h4>Items <button class="btn btn-info btn-sm add_item" type="button"><i class="fas fa-plus"></i></button></h4>

                        <div class="sectoin_items">
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="item[]" placeholder="Item Name*" required>

                                    <div class="input-group-append">
                                        <span class="input-group-btn">
                                            <button class="btn btn-danger input_group_btn remove_item" type="button" title="Remove Item">
                                            <i class="fas fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success btn-block">Create</button>
                    <small><b>NB: *</b> marked are required field.</small>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h4 class="d-inline-block">Back End</h4>

        <button class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#BackOrderModal">Change Section Order</button>

        @if(count($back_sections))
        <a href="{{route('back.projects.checkUncheck', ['project' => $project->id, 'group' => 'Back End', 'status' => 1])}}" class="btn btn-info btn-sm float-right mr-2 check_status_btn"><i class="fas fa-check"></i> Check All</a>
        <a href="{{route('back.projects.checkUncheck', ['project' => $project->id, 'group' => 'Back End', 'status' => 0])}}" class="btn btn-danger btn-sm float-right mr-2 check_status_btn"><i class="fas fa-times"></i> Uncheck All</a>
        @endif
    </div>

    @if(count($back_sections))
        @foreach ($back_sections as $section)
            @include('back.projects.inc.section-loop')
        @endforeach
    @else
        <div class="card-body">
            <p>No back end items!</p>
        </div>
    @endif
</div>

<div class="card mt-4">
    <div class="card-header">
        <h4 class="d-inline-block">Front End</h4> 

        <button class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#frontOrderModal">Change Section Order</button>

        @if(count($front_sections))
        <a href="{{route('back.projects.checkUncheck', ['project' => $project->id, 'group' => 'Front End', 'status' => 1])}}" class="btn btn-info btn-sm float-right mr-2 check_status_btn"><i class="fas fa-check"></i> Check All</a>
        <a href="{{route('back.projects.checkUncheck', ['project' => $project->id, 'group' => 'Front End', 'status' => 0])}}" class="btn btn-danger btn-sm float-right mr-2 check_status_btn"><i class="fas fa-times"></i> Uncheck All</a>
        @endif
    </div>

    @if(count($front_sections))
        @foreach ($front_sections as $section)
            @include('back.projects.inc.section-loop')
        @endforeach
    @else
        <div class="card-body">
            <p>No front end items!</p>
        </div>
    @endif
</div>

<div class="text-center mt-4">
    @if($project->status == 1)
    <a href="{{route('back.projects.submit', ['project' => $project->id, 'status' => 2])}}" class="btn btn-success">Submit to "Dev 2"</a>
    @elseif($project->status == 2)
    <a href="{{route('back.projects.submit', ['project' => $project->id, 'status' => 3])}}" class="btn btn-success">Submit to "QC"</a>
    @elseif($project->status == 3)
    <a href="{{route('back.projects.submit', ['project' => $project->id, 'status' => 4])}}" class="btn btn-success">Submit to "QA"</a>
    @endif
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="{{route('back.projects.sectionItemCreate')}}" method="POST">
            @csrf
            <input type="hidden" name="section_id" class="section_id">
            <input type="hidden" name="item_id" class="item_id">

            <div class="modal-body">
                <div class="item_group">
                    <h4>Items <button class="btn btn-info btn-sm add_item" type="button"><i class="fas fa-plus"></i></button></h4>

                    <div class="sectoin_items">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" type="text" name="item[]" placeholder="Item Name*" required>
                                <div class="input-group-append">
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger input_group_btn remove_item" type="button" title="Remove Item">
                                        <i class="fas fa-times"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Create</button>
            </div>
        </form>
      </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="{{route('back.projects.sectionItemUpdarte')}}" method="POST">
            @csrf
            <input type="hidden" name="item_id" class="item_id">

            <div class="modal-body">
                <div class="item_group">
                    <div class="sectoin_items">
                        <div class="form-group">
                            <label><b>Item Name*</b></label>
                            <input class="form-control item_name" type="text" name="name" value="" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <a class="btn btn-danger delete_modal_item" href="" onclick="return confirm('Are you sure to remove?');">Delete</a>
              <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
      </div>
    </div>
</div>

<!-- Add Comment Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="commentModalLabel">Add Comment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="{{route('back.projects.addComment')}}" method="POST">
            @csrf
            <input type="hidden" name="item_id" class="comment_item_id">
            <input type="hidden" name="type" class="comment_type">

            <div class="modal-body">
                <div class="form-group">
                    <label><b>Comment*</b></label>

                    <textarea id="editor" class="form-control form-control-sm" name="comment" cols="30" rows="3">{{old('description')}}</textarea>
                    {{-- <input class="form-control" type="text" name="comment" required> --}}
                </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Submit</button>
              <button type="submit" class="btn btn-success">Create</button>
            </div>
        </form>
      </div>
    </div>
</div>

<!-- View Comment Modal -->
<div class="modal fade" id="viewCommentModal" tabindex="-1" role="dialog" aria-labelledby="viewCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewCommentModalLabel">View Comment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body comment_details">

        </div>
      </div>
    </div>
</div>

<!-- Front Order Modal -->
<div class="modal fade" id="frontOrderModal" tabindex="-1" role="dialog" aria-labelledby="frontOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="frontOrderModalLabel">Change Frone End Section</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="{{route('back.projects.sectionPosition')}}" method="POST">
            @csrf

            <div class="modal-body">
                <ul class="moveContent npnls">
                    @foreach ($front_sections as $front_section)
                        <input type="hidden" name="position[]" value="{{$front_section->id}}">

                        <li class="section_{{$front_section->id}}">
                            <i class="fa fa-arrows-alt"></i>
                            {{$front_section->name}}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
      </div>
    </div>
</div>

<!-- Back Order Modal -->
<div class="modal fade" id="BackOrderModal" tabindex="-1" role="dialog" aria-labelledby="BackOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="BackOrderModalLabel">Change Frone End Section</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="{{route('back.projects.sectionPosition')}}" method="POST">
            @csrf

            <div class="modal-body">
                <ul class="moveContent npnls">
                    @foreach ($back_sections as $back_section)
                        <input type="hidden" name="position[]" value="{{$back_section->id}}">

                        <li class="section_{{$back_section->id}}">
                            <i class="fa fa-arrows-alt"></i>
                            {{$back_section->name}}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection

@section('footer')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

    <script>
        // CKEditor
        $(function () {
            CKEDITOR.replace('editor', {
                height: 200,
                filebrowserUploadUrl: "{{route('imageUpload')}}?",
                disableNativeSpellChecker : false,
            });
        });
    </script>

    <script src="{{asset('back/js/jquery-sortable.js')}}"></script>
    <script>
        $(function () {
            $(".moveContent").sortable();
        });
    </script>

    <script>
        $(document).on('click', '.add_item', function(){
            let html = '<div class="form-group">' +
                            '<div class="input-group">' +
                                '<input class="form-control" type="text" name="item[]" placeholder="Item Name*" required>' +

                                '<div class="input-group-append">' +
                                    '<span class="input-group-btn">' +
                                        '<button class="btn btn-danger input_group_btn type="button" remove_item" title="Remove Item">' +
                                        '<i class="fas fa-times"></i></button>' +
                                    '</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

            $(this).closest('.item_group').find('.sectoin_items').append(html);
        });
        $(document).on('click', '.remove_item', function(){
            $(this).closest('.form-group').remove();
        });

        $(document).on('click', '.add_item_modal_btn', function(){
            let section = $(this).data('section');
            let item = $(this).data('item');

            $('.section_id').val(section);
            $('.item_id').val(item);
        });

        $(document).on('click', '.edit_item_modal_btn', function(){
            let item = $(this).data('item');
            let name = $(this).data('name');
            let delete_item = $(this).data('delete');

            $('.item_id').val(item);
            $('.item_name').val(name);
            $('.delete_modal_item').attr('href', delete_item);
        });
        $(document).on('click', '.item_checkbox', function(){
            let item_id = $(this).val();
            let type = $(this).data('type');

            $.ajax({
                url: '{{route("back.projects.itemCheck")}}',
                method: 'GET',
                data: {item_id, type},
                context: this,
                success: function(result){
                    if(result == '1'){
                        $(this).closest('tr').addClass('table-success');
                        $(this).closest('tr').removeClass('table-warning');
                        $(this).closest('tr').removeClass('table-danger');
                    }else{
                        $(this).closest('tr').removeClass('table-success');
                        $(this).closest('tr').addClass('table-warning');
                    }
                },
                error: function(){
                    console.log('Something wrong from item checkbox!');
                }
            });
        });

        // Comment Modal
        $(document).on('click', '.comment_btn', function(){
            let item_id = $(this).data('item');
            let comment_type = $(this).data('type');

            $('.comment_item_id').val(item_id);
            $('.comment_type').val(comment_type);
        });

        // Check/Uncheck All
        // $(document).on('click', '.check_status_btn', function(){
        //     let group = $(this).data('group');
        //     let type = $(this).data('type');
        //     let project = "{{$project->id}}";
        //     let status = "{{$project->status}}";

        //     cLoader();

        //     $.ajax({
        //         url: '',
        //         method: 'POST',
        //         data: {group, type, project, status, _token: "{{csrf_token()}}"},
        //         success: function(){
        //             // cAlert('error', 'Something wring!');
        //         },
        //         error: function(){
        //             cLoader('hide');
        //             cAlert('error', 'Something wring!');
        //         }
        //     });
        // });

        // View Comment
        $(document).on('click', '.comment_view_btn', function(){
            let item_id = $(this).data('item');
            let type = $(this).data('type');

            cLoader();
            $.ajax({
                url: '{{route("back.projects.viewComment")}}',
                method: 'POST',
                data: {item_id, type, _token: '{{csrf_token()}}'},
                success: function(result){
                    cLoader('hide');
                    $('.comment_details').html(result);
                },
                error: function(){
                    cLoader('hide');
                }
            });
        });
    </script>
@endsection
