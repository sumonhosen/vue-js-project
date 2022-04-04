<div class="card-body table-responsive">
    <h5 class="d-inline-block">{{$section->name}}</h5>
    @if($project->status == 1 || $project->status == 2 || $project->status == 3)
    <button class="btn btn-success btn-sm add_item_modal_btn d-inline-block" data-toggle="modal" data-section="{{$section->id}}" data-item="" data-target="#addItemModal"><i class="fas fa-plus"></i> Add Sub Item</button>
    @endif

    <ul class="nav nav-tabs float-right mb-2" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link {{$project->status == 1 ? 'active' : ''}}" id="dev_1-tab" data-toggle="tab" href="#section_{{$section->id}}_dev_1" role="tab" aria-controls="dev_1" aria-selected="true">Dev 1</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{$project->status == 2 ? 'active' : ''}} {{$project->status < 2 ? 'disabled' : ''}}" id="dev_2-tab" data-toggle="tab" href="#section_{{$section->id}}_dev_2" role="tab" aria-controls="dev_2" aria-selected="true">Dev 2</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{$project->status == 3 ? 'active' : ''}} {{$project->status < 3 ? 'disabled' : ''}}" id="qa-tab" data-toggle="tab" href="#section_{{$section->id}}_qc" role="tab" aria-controls="qc" aria-selected="true">QC</a>
        </li>

        <li class="nav-item">
          <a class="nav-link {{$project->status == 4 ? 'active' : ''}} {{$project->status < 4 ? 'disabled' : ''}}" id="qa-tab" data-toggle="tab" href="#section_{{$section->id}}_qa" role="tab" aria-controls="qa" aria-selected="true">QA</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{$project->status == 1 ? 'show active' : ''}}" id="section_{{$section->id}}_dev_1" role="tabpanel" aria-labelledby="dev_1-tab">
            <table class="table table-sm table-bordered">
                <tbody>
                    @php
                        $section_SectionItems = $section->SectionItems->where('dev_2', 0);
                    @endphp
                    @foreach ($section_SectionItems as $item)
                        @php
                            $SectionItems = $item->SectionItems->where('dev_2', 0);
                        @endphp
                        <tr class="{{$item->developer_1_status ? "table-success" : "table-warning"}}">
                            <td style="width: 90px;" class="td_bg_normal" rowspan="{{count($SectionItems) ? count($SectionItems) : '1'}}">
                                @include('back.projects.inc.edit-item-btn')

                                @if($project->status == 1)
                                    <button class="btn btn-sm btn-success add_item_modal_btn" title="Add Item" data-toggle="modal" data-section="{{$section->id}}" data-item="{{$item->id}}" data-target="#addItemModal"><i class="fas fa-plus"></i></button>
                                @endif
                            </td>
                            <th {{count($SectionItems) ? 'class=td_bg_normal' : 'colspan=2'}} rowspan="{{count($SectionItems) ? count($SectionItems) : '1'}}">{{$item->name}}</th>

                            @if(count($SectionItems))
                                @include('back.projects.inc.sub-sub-item', [
                                    'item' => $SectionItems[0]
                                ])
                            @endif

                            <td class="text-right" style="width: 30px"><input type="checkbox" {{$item->developer_1_status ? 'checked' : ''}} class="item_checkbox" value="{{$item->id}}" data-type="developer_1_status" {{$project->status == 1 ? '' : 'disabled'}}></td>
                        </tr>

                        @foreach ($SectionItems as $key => $sub_item)
                            @if($key > 0)
                            <tr class="{{$sub_item->developer_1_status ? "table-success" : "table-warning"}}">
                                @include('back.projects.inc.sub-sub-item', [
                                    'item' => $sub_item
                                ])

                                <td class="text-right" style="width: 30px"><input type="checkbox" {{$sub_item->developer_1_status ? 'checked' : ''}} class="item_checkbox" value="{{$sub_item->id}}" data-type="developer_1_status" {{$project->status == 1 ? '' : 'disabled'}}></td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade {{$project->status == 2 ? 'show active' : ''}}" id="section_{{$section->id}}_dev_2" role="tabpanel" aria-labelledby="dev_2-tab">
            <table class="table table-sm table-bordered">
                <tbody>
                    @foreach ($section->SectionItems as $item)
                        <tr class="{{$item->SectionItems[0]->dev_b_row_class ?? $item->dev_b_row_class}}">
                            <td style="width: 90px;" class="td_bg_normal" rowspan="{{count($item->SectionItems) ? count($item->SectionItems) : '1'}}">
                                @if($project->status == 2)
                                    @if($item->deleted_at)
                                        <div class="text-center">
                                            Deleted
                                        </div>
                                    @else
                                        @if($project->status == 2)
                                            @include('back.projects.inc.edit-item-btn')
                                        @endif

                                        <button class="btn btn-sm btn-success add_item_modal_btn" title="Add Item" data-toggle="modal" data-section="{{$section->id}}" data-item="{{$item->id}}" data-target="#addItemModal"><i class="fas fa-plus"></i></button>
                                    @endif
                                @endif
                            </td>
                            <th {{count($item->SectionItems) ? 'class=td_bg_normal' : 'colspan=2'}} rowspan="{{count($item->SectionItems) ? count($item->SectionItems) : '1'}}">{{$item->name . ($item->dev_b_status_string)}}</th>

                            @if(count($item->SectionItems))
                            <td class="{{$item->SectionItems[0]->dev_b_row_class}}">
                                @if($project->status == 2 && !$item->SectionItems[0]->deleted_at)
                                    @include('back.projects.inc.edit-item-btn', [
                                        'item' => $item->SectionItems[0]
                                    ])
                                @endif

                                {{$item->SectionItems[0]->name . ($item->SectionItems[0]->dev_b_status_string)}}</td>
                            @endif

                            <td class="text-right" style="width: 30px">
                                @if(count($item->SectionItems))
                                    @if(!$item->SectionItems[0]->deleted_at)
                                        <input type="checkbox" {{$item->SectionItems[0]->developer_2_status ? 'checked' : ''}} class="item_checkbox" value="{{$item->SectionItems[0]->id}}" data-type="developer_2_status" {{$project->status == 2 ? '' : 'disabled'}}>
                                    @endif
                                @else
                                    @if(!$item->deleted_at)
                                        <input type="checkbox" {{$item->developer_2_status ? 'checked' : ''}} class="item_checkbox" value="{{$item->id}}" data-type="developer_2_status" {{$project->status == 2 ? '' : 'disabled'}}>
                                    @endif
                                @endif
                            </td>

                            <td style="width: 45px" class="text-right">
                                @if(count($item->SectionItems))
                                    @if($item->SectionItems[0]->developer_2_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$item->SectionItems[0]->id}}" data-type="developer_2_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$item->SectionItems[0]->id}}" data-target="#commentModal" data-type="developer_2_comment"></i>
                                    @endif
                                @else
                                    @if($item->developer_2_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$item->id}}" data-type="developer_2_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$item->id}}" data-target="#commentModal" data-type="developer_2_comment"></i>
                                    @endif
                                @endif
                            </td>
                        </tr>

                        @foreach ($item->SectionItems as $key => $sub_item)
                            @if($key > 0)
                            <tr class="{{$sub_item->dev_b_row_class}}">
                                <td>
                                    @if(!$sub_item->deleted_at && $project->status == 2)
                                        @include('back.projects.inc.edit-item-btn', [
                                            'item' => $sub_item
                                        ])
                                    @endif

                                    {{$sub_item->name . $sub_item->dev_b_status_string}}
                                </td>

                                <td class="text-right" style="width: 30px">
                                    @if(!$sub_item->deleted_at)
                                        <input type="checkbox" {{$sub_item->developer_2_status ? 'checked' : ''}} class="item_checkbox" value="{{$sub_item->id}}" data-type="developer_2_status" {{$project->status == 2 ? '' : 'disabled'}}>
                                    @endif
                                </td>

                                <td style="width: 45px" class="text-right">
                                    @if($item->developer_2_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$item->id}}" data-type="developer_2_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$item->id}}" data-target="#commentModal" data-type="developer_2_comment" data-type="developer_2_comment"></i>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($project->status >= 3)
        <div class="tab-pane fade {{$project->status == 3 ? 'show active' : ''}}" id="section_{{$section->id}}_qc" role="tabpanel" aria-labelledby="qc-tab">
            <table class="table table-sm table-bordered">
                <tbody>
                    @foreach ($section->SectionItems as $item)
                        @php
                            $qc_SectionItems = $item->SectionItems;
                            $first_key = 0;
                        @endphp

                        <tr class="{{$qc_SectionItems[$first_key]->qc_row_class ?? $item->qc_row_class}}">
                            <td style="width: 90px;" class="td_bg_normal" rowspan="{{count($qc_SectionItems) ? count($qc_SectionItems) : '1'}}">
                                @if($project->status == 3)
                                    @if($item->deleted_at)
                                        <div class="text-center">
                                            Deleted
                                        </div>
                                    @else
                                        @if($project->status == 3)
                                            @include('back.projects.inc.edit-item-btn')
                                        @endif

                                        <button class="btn btn-sm btn-success add_item_modal_btn" title="Add Item" data-toggle="modal" data-section="{{$section->id}}" data-item="{{$item->id}}" data-target="#addItemModal"><i class="fas fa-plus"></i></button>
                                    @endif
                                @endif
                            </td>
                            <th {{count($qc_SectionItems) ? 'class=td_bg_normal' : 'colspan=2'}} rowspan="{{count($qc_SectionItems) ? count($qc_SectionItems) : '1'}}">{{$item->name . ($item->dev_b_status_string)}}</th>

                            @if(count($qc_SectionItems))
                            <td class="{{$qc_SectionItems[$first_key]->qc_row_class}}">
                                @if($project->status == 3 && !$qc_SectionItems[$first_key]->deleted_at)
                                    @include('back.projects.inc.edit-item-btn', [
                                        'item' => $qc_SectionItems[$first_key]
                                    ])
                                @endif

                                {{$qc_SectionItems[$first_key]->name . ($qc_SectionItems[$first_key]->dev_b_status_string)}}</td>
                            @endif

                            <td class="text-right" style="width: 30px">
                                @if(count($qc_SectionItems))
                                    @if(!$qc_SectionItems[$first_key]->deleted_at)
                                        <input type="checkbox" {{$qc_SectionItems[$first_key]->qc_status ? 'checked' : ''}} class="item_checkbox" value="{{$qc_SectionItems[$first_key]->id}}" data-type="qc_status" {{$project->status == 3 ? '' : 'disabled'}}>
                                    @endif
                                @else
                                    @if(!$item->deleted_at)
                                        <input type="checkbox" {{$item->qc_status ? 'checked' : ''}} class="item_checkbox" value="{{$item->id}}" data-type="qc_status" {{$project->status == 3 ? '' : 'disabled'}}>
                                    @endif
                                @endif
                            </td>

                            <td style="width: 45px" class="text-right">
                                @if(count($qc_SectionItems))
                                    @if($qc_SectionItems[$first_key]->qc_status_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$qc_SectionItems[$first_key]->id}}" data-type="qc_status_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$qc_SectionItems[$first_key]->id}}" data-target="#commentModal" data-type="qc_status_comment"></i>
                                    @endif
                                @else
                                    @if($item->qc_status_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$item->id}}" data-type="qc_status_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$item->id}}" data-target="#commentModal" data-type="qc_status_comment"></i>
                                    @endif
                                @endif
                            </td>
                        </tr>

                        @foreach ($qc_SectionItems as $key => $sub_item)
                            @if($key > 0)
                            <tr class="{{$sub_item->qc_row_class}}">
                                <td>
                                    @if(!$sub_item->deleted_at && $project->status == 3)
                                        @include('back.projects.inc.edit-item-btn', [
                                            'item' => $sub_item
                                        ])
                                    @endif

                                    {{$sub_item->name . $sub_item->dev_b_status_string}}
                                </td>

                                <td class="text-right" style="width: 30px">
                                    @if(!$sub_item->deleted_at)
                                        <input type="checkbox" {{$sub_item->qc_status ? 'checked' : ''}} class="item_checkbox" value="{{$sub_item->id}}" data-type="qc_status" {{$project->status == 3 ? '' : 'disabled'}}>
                                    @endif
                                </td>

                                <td style="width: 45px" class="text-right">
                                    @if($item->qc_status_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$item->id}}" data-type="qc_status_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$item->id}}" data-target="#commentModal" data-type="qc_status_comment"></i>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        @if($project->status >= 4)
        <div class="tab-pane fade {{$project->status == 4 ? 'show active' : ''}}" id="section_{{$section->id}}_qa" role="tabpanel" aria-labelledby="qa-tab">
            <table class="table table-sm table-bordered">
                <tbody>
                    @foreach ($section->SectionItems->where('deleted_at', null) as $item)
                        @php
                            $qa_SectionItems = $item->SectionItems->where('deleted_at', null);

                            $qa_first_key = "123";
                            foreach ($qa_SectionItems as $qa_key => $value) {
                                if($qa_first_key === "123"){
                                    $qa_first_key = $qa_key;
                                }
                            }

                            if($first_key === "123"){
                                $first_key = 0;
                            }
                        @endphp

                        <tr class="{{$qa_SectionItems[$first_key]->qa_row_class ?? $item->qa_row_class}}">
                            <th {{count($qa_SectionItems) ? 'class=td_bg_normal' : 'colspan=2'}} rowspan="{{count($qa_SectionItems) ? count($qa_SectionItems) : '1'}}">{{$item->name . ($item->qa_status_string)}}</th>

                            @if(count($qa_SectionItems))
                                <td class="{{$qa_SectionItems[$first_key]->qa_row_class}}">
                                    {{$qa_SectionItems[$first_key]->name . ($qa_SectionItems[$first_key]->dev_b_status_string)}}
                                </td>
                            @endif

                            <td class="text-right" style="width: 30px">
                                @if(count($qa_SectionItems))
                                    @if(!$qa_SectionItems[$first_key]->deleted_at)
                                        <input type="checkbox" {{$qa_SectionItems[$first_key]->qa_status ? 'checked' : ''}} class="item_checkbox" value="{{$qa_SectionItems[$first_key]->id}}" data-type="qa_status" {{$project->status == 4 ? '' : 'disabled'}}>
                                    @endif
                                @else
                                    @if(!$item->deleted_at)
                                        <input type="checkbox" {{$item->qa_status ? 'checked' : ''}} class="item_checkbox" value="{{$item->id}}" data-type="qa_status" {{$project->status == 4 ? '' : 'disabled'}}>
                                    @endif
                                @endif
                            </td>

                            <td style="width: 45px" class="text-right">
                                @if(count($qa_SectionItems))
                                    @if($qa_SectionItems[$first_key]->qa_status_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$qa_SectionItems[$first_key]->id}}" data-type="qa_status_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$qa_SectionItems[$first_key]->id}}" data-target="#commentModal" data-type="qa_status_comment"></i>
                                    @endif
                                @else
                                    @if($item->qa_status_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$item->id}}" data-type="qa_status_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$item->id}}" data-target="#commentModal" data-type="qa_status_comment"></i>
                                    @endif
                                @endif
                            </td>
                        </tr>

                        @foreach ($qa_SectionItems as $key => $sub_item)
                            @if($key > 0)
                            <tr class="{{$sub_item->qa_row_class}}">
                                <td>
                                    {{$sub_item->name}}
                                </td>

                                <td class="text-right" style="width: 30px">
                                    @if(!$sub_item->deleted_at)
                                        <input type="checkbox" {{$sub_item->qa_status ? 'checked' : ''}} class="item_checkbox" value="{{$sub_item->id}}" data-type="qa_status" {{$project->status == 4 ? '' : 'disabled'}}>
                                    @endif
                                </td>

                                <td style="width: 45px" class="text-right">
                                    @if($item->qa_status_comment)
                                        <i class="fas fa-comment text-success comment_view_btn" data-toggle="modal" data-item="{{$item->id}}" data-type="qa_status_comment" data-target="#viewCommentModal"></i>
                                    @else
                                        <i class="fas fa-comment comment_btn" data-toggle="modal" data-item="{{$item->id}}" data-target="#commentModal" data-type="qa_status_comment"></i>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <hr>
</div>
