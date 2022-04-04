<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\DevItem;
use App\Models\Project;
use App\Models\Section;
use App\Models\User;
use App\Models\SectionItem;
use App\Repositories\MediaRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $projects = Project::get();

        return view('back.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('type', 'admin')->get();
        return view('back.projects.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v_data = [
            'name' => 'required|max:255',
            'client_name' => 'max:255',
            'duration' => 'required|max:255',
            'client_location' => 'max:255',
        ];
        if($request->file('image')){
            $v_data['image'] = 'mimes:jpg,png,jpeg,gif';
        }
        $request->validate($v_data);

        $project = new Project;
        $project->name = $request->name;
        $project->client_name = $request->client_name;
        $project->duration = $request->duration;
        $project->client_location = $request->client_location;
        $project->user_id = $request->user_id;
        $project->description = $request->description;

        if($request->file('image')){
            $uploaded_file = MediaRepo::upload($request->file('image'));
            $project->image = $uploaded_file['full_file_name'];
            $project->media_id = $uploaded_file['media_id'];
        }

        if($request->file('file')){
            $file = $request->file('file');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/projects';
            $file->move($destination, $file_name);

            $project->file = $file_name;
        }

        $project->save();

        return redirect()->back()->with('success-alert', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    { 
        $back_sections = Section::with('SectionItems', 'SectionItems.SectionItems')->where('project_id', $project->id)->where('group', 'Back End')->orderBy('position')->get();
        $front_sections = Section::with('SectionItems', 'SectionItems.SectionItems')->where('project_id', $project->id)->where('group', 'Front End')->orderBy('position')->get();

        return view('back.projects.show', compact('project', 'back_sections', 'front_sections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $users = User::where('type', 'admin')->get();
        return view('back.projects.edit', compact('project','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $v_data = [
            'name' => 'required|max:255',
            'client_name' => 'max:255',
            'duration' => 'required|max:255',
            'client_location' => 'max:255',
        ];
        if($request->file('image')){
            $v_data['image'] = 'mimes:jpg,png,jpeg,gif';
        }
        $request->validate($v_data);

        $project->name = $request->name;
        $project->client_name = $request->client_name;
        $project->duration = $request->duration;
        $project->client_location = $request->client_location;
        $project->user_id = $request->user_id;
        $project->description = $request->description;

        if($request->file('image')){
            $uploaded_file = MediaRepo::upload($request->file('image'));
            $project->image = $uploaded_file['full_file_name'];
            $project->media_id = $uploaded_file['media_id'];
        }

        if($request->file('file')){
            $file = $request->file('file');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/projects';
            $file->move($destination, $file_name);

            $project->file = $file_name;
        }

        $project->save();

        return redirect()->back()->with('success-alert', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('back.projects.index')->with('success-alert', 'Project deleted successfully.');
    }

    // Delete Image
    public function removeImage(Project $project){
        $project->image = null;
        $project->media_id = null;
        $project->save();

        return redirect()->back()->with('success-alert', 'Bank image deleted successfully.');
    }

    public function sectionCreate(Request $request, Project $project){
       

        $request->validate([
            'name' => 'required|max:255',
            'group' => 'required|max:255'
        ]);

        $section = new Section;
        $section->name = $request->name;
        $section->group = $request->group;
        $section->note = $request->note;
        $section->project_id = $project->id;
        $section->save();

        foreach((array)$request->item as $item){
            $section_item = new SectionItem;
            $section_item->name = $item;
            $section_item->section_id = $section->id;

            if($project->status == 2){
                $section_item->dev_2 = 1;
            }

            $section_item->save();
        }

        return redirect()->back()->with('success-alert', 'Section created successfully.');
    }

    public function sectionDelete(Section $section){
        $section->delete();

        return redirect()->back()->with('success-alert', 'Section deleted successfully.');
    }
    public function sectionItemDelete(SectionItem $section_item){
        $section_item->deleted_at = Carbon::now();
        // $section_item->delete();
        if(isset($section_item->Section->Project) && $section_item->Section->Project->status == 1){
            $section_item->delete();
        }else{
            $section_item->save();
        }

        return redirect()->back()->with('success-alert', 'Section item deleted successfully.');
    }
    public function sectionItemCreate(Request $request){
        $request->validate([
            'item' => 'required|max:255',
            'section_id' => 'required'
        ]);

        $section = Section::find($request->section_id);
        foreach((array)$request->item as $item){
            $srction_item = new SectionItem;
            $srction_item->name = $item;
            $srction_item->section_id = $request->section_id;
            $srction_item->parent_id = $request->item_id;

            if($section->Project && ($section->Project->status == 2 || $section->Project->status == 3)){
                $srction_item->dev_2 = 1;
            }

            $srction_item->save();
        }

        return redirect()->back()->with('success-alert', 'Section item created successfully.');
    }
    public function sectionItemUpdarte(Request $request){
        $request->validate([
            'item_id' => 'required|max:255',
            'name' => 'required|max:255'
        ]);

        $srction_item = SectionItem::findOrFail($request->item_id);
        $srction_item->name = $request->name;
        $srction_item->save();

        return redirect()->back()->with('success-alert', 'Section item updated successfully.');
    }

    public function itemCheck(Request $request){
        $section_item = SectionItem::find($request->item_id);
        if($section_item){
            if($section_item[$request->type] == 1){
                $section_item[$request->type] = 0;
            }else{
                $section_item[$request->type] = 1;
            }
            $section_item->save();
            // dd($section_item);

            // if($section_item->SectionItem){
            //     if($section_item->SectionItem->SectionItems->where('developer_1_status', 0)->count() == 0){
            //         $section_item->SectionItem->developer_1_status == 1;
            //         $section_item->SectionItem->save();
            //     }
            //     // if($section_item->SectionItem->SectionItems->where('developer_2_status', 0)->count() == 0){
            //     //     $section_item->SectionItem->developer_2_status == 1;
            //     //     $section_item->SectionItem->save();
            //     // }
            //     // if($section_item->SectionItem->SectionItems->where('qc_status', 0)->count() == 0){
            //     //     $section_item->SectionItem->qc_status == 1;
            //     //     $section_item->SectionItem->save();
            //     // }
            //     // if($section_item->SectionItem->SectionItems->where('qa_status', 0)->count() == 0){
            //     //     $section_item->SectionItem->qa_status == 1;
            //     //     $section_item->SectionItem->save();
            //     // }
            // }
            return $section_item[$request->type];
        }

        return 'false';
    }

    public function submit(Project $project, $status){
        if($status == 3){
            $dev_2_status = true;
            $sections = $project->Sections;

            foreach($sections as $section){
                foreach($section->SectionItems as $item){
                    if(count($item->SectionItems)){
                        foreach($item->SectionItems as $item){
                            if($dev_2_status && !$item->deleted_at && $item->developer_2_status == 0){
                                $dev_2_status = false;
                            }
                        }
                    }else{
                        if($dev_2_status && !$item->deleted_at && $item->developer_2_status == 0){
                            $dev_2_status = false;
                        }
                    }
                }
            }

            if(!$dev_2_status){
                return redirect()->back()->with('error', 'Please fillup all the checklists');
            }
        }elseif($status == 4){
            $qc_status = true;
            $sections = $project->Sections;

            foreach($sections as $section){
                foreach($section->SectionItems as $item){
                    if(count($item->SectionItems)){
                        foreach($item->SectionItems as $item){
                            if($qc_status && !$item->deleted_at && $item->qc_status == 0){
                                $qc_status = false;
                            }
                        }
                    }else{
                        if($qc_status && !$item->deleted_at && $item->qc_status == 0){
                            $qc_status = false;
                        }
                    }
                }
            }

            if(!$qc_status){
                return redirect()->back()->with('error', 'Please fillup all the checklists');
            }
        }

        // if($project->status == 1 && $status == 2){
        //     foreach($project->Sections as $section){
        //         foreach($section->SectionItems as $item){
        //             $dev_item = new DevItem;
        //             $dev_item->section_id = $item->section_id;
        //             $dev_item->parent_id = null;
        //             $dev_item->name = $item->name;
        //             $dev_item->note = $item->note;
        //             $dev_item->image = $item->image;
        //             $dev_item->developer_2_status = $item->developer_2_status;
        //             $dev_item->qc_status = $item->qc_status;
        //             $dev_item->qa_status = $item->qa_status;
        //             $dev_item->save();

        //             foreach($item->SectionItems as $sub_item){
        //                 $sub_dev_item = new DevItem;
        //                 $sub_dev_item->section_id = $sub_item->section_id;
        //                 $sub_dev_item->parent_id = $dev_item->parent_id;
        //                 $sub_dev_item->name = $sub_item->name;
        //                 $sub_dev_item->note = $sub_item->note;
        //                 $sub_dev_item->image = $sub_item->image;
        //                 $sub_dev_item->developer_2_status = $sub_item->developer_2_status;
        //                 $sub_dev_item->qc_status = $sub_item->qc_status;
        //                 $sub_dev_item->qa_status = $sub_item->qa_status;
        //                 $sub_dev_item->save();
        //             }
        //         }
        //     }
        // }
        $project->status = $status;
        $project->save();

        return redirect()->back()->with('success-alert', 'Project moved successfully.');
    }

    public function addComment(Request $request){
        $request->validate([
            'comment' => 'required',
            'item_id' => 'required',
            'type' => 'required'
        ]);

        $section_item = SectionItem::find($request->item_id);

        if($request->type == 'qa_status_comment'){
            $section_item->qa_status_comment = $request->comment;
        }elseif($request->type == 'qc_status_comment'){
            $section_item->qc_status_comment = $request->comment;
        }else{
            $section_item->developer_2_comment = $request->comment;
        }
        $section_item->save();

        return redirect()->back()->with('success-alert', 'Coment added successfully.');
    }
    public function viewComment(Request $request){
        $item = SectionItem::find($request->item_id);

        if($item){
            if($request->type == 'developer_2_comment'){
                return $item->developer_2_comment;
            }elseif($request->type == 'qc_status_comment'){
                return $item->qc_status_comment;
            }elseif($request->type == 'qa_status_comment'){
                return $item->qa_status_comment;
            }
        }
        return 'No comment available!';
    }

    public function sectionPosition(Request $request){
        foreach ($request->position as $i => $data) {
            $query = Section::find($data);
            $query->position = $i;
            $query->save();
        }

        return redirect()->back()->with('success-alert', 'Position updated successfully.');
    }

    public function checkUncheck(Project $project, $group, $status){
        $sections_id = Section::where('project_id', $project->id)->where('group', $group)->pluck('id')->toArray();

        if($project->status == 1){
            SectionItem::whereIn('section_id', $sections_id)->where('deleted_at', null)->update([
                'developer_1_status' => $status
            ]);
        }elseif($project->status == 2){
            SectionItem::whereIn('section_id', $sections_id)->where('deleted_at', null)->update([
                'developer_2_status' => $status
            ]);
        }elseif($project->status == 3){
            SectionItem::whereIn('section_id', $sections_id)->where('deleted_at', null)->update([
                'qc_status' => $status
            ]);
        }elseif($project->status == 4){
            SectionItem::whereIn('section_id', $sections_id)->where('deleted_at', null)->update([
                'qa_status' => $status
            ]);
        }

        return redirect()->back()->with('success-alert', 'Project updated successfully.');
    }
}
