<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DevItem;
use App\Models\Project;
use App\Models\Section;
use App\Models\User;
use App\Models\SectionItem;
use App\Repositories\MediaRepo;
use Carbon\Carbon;

class ProjectController extends Controller
{
    public function store(Request $request){
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
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/projects';
            $file->move($destination, $file_name);
            $project->image = $file_name;
        }

        if($request->file('file')){
            $file = $request->file('file');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/projects';
            $file->move($destination, $file_name);

            $project->file = $file_name;
        }
        $project->save();

        return response()->json(['status'=>'success','message'=>'Successfully stored'],200);
    }
    public function index(){
        $projects = Project::get();
        return response()->json($projects,200);
    }
    public function assignUsers(){
        $users = User::where('type', 'admin')->get();
        return response()->json($users,200);
    }
    public function show($project_id){ 
        $project = Project::where('id',$project_id)->first();

        $back_sections = Section::with('SectionItems', 'SectionItems.SectionItems')->where('project_id', $project_id)->where('group', 'Back End')->orderBy('position')->get();
        $front_sections = Section::with('SectionItems', 'SectionItems.SectionItems')->where('project_id', $project_id)->where('group', 'Front End')->orderBy('position')->get();

        $data            = [];
        $data['project'] = $project;
        $data['back_sections'] = $back_sections;
        $data['front_sections'] = $front_sections;
        return response()->json($data,200);
    }
    public function sectionCreate(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'group' => 'required|max:255'
        ]);
        $project = Project::where('id',$request->project_id)->first();

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
         return response()->json(['status'=>'success','message'=>'Successfully stored'],200);
    }

    public function sectionItemCreate(Request $request){

        $section = Section::find($request->section_id);
       

        foreach((array)$request->sec_items as $item){
            $srction_item = new SectionItem;
            $srction_item->name = $item;
            $srction_item->section_id = $request->section_id;
            $srction_item->parent_id = $request->item_id;

            if($section->Project && ($section->Project->status == 2 || $section->Project->status == 3)){
                $srction_item->dev_2 = 1;
            }

            $srction_item->save();
        }
        return response()->json(['status'=>'success','message'=>'Successfully stored'],200);
    }
    public function edit($project_id)
    {
        $data = Project::find($project_id);
        return response()->json($data,200);
    }
    public function update(Request $request, $project_id)
    {
        $project = Project::find($project_id);
   
        // $v_data = [
        //     'name' => 'required|max:255',
        //     'client_name' => 'max:255',
        //     'duration' => 'required|max:255',
        //     'client_location' => 'max:255',
        // ];
        // if($request->file('image')){
        //     $v_data['image'] = 'mimes:jpg,png,jpeg,gif';
        // }
        // $request->validate($v_data);

        $project->name = $request->name;
        $project->client_name = $request->client_name;
        $project->duration = $request->duration;
        $project->client_location = $request->client_location;
        $project->user_id = $request->user_id;
        $project->description = $request->description;

        if($request->file('image')){
            $file = $request->file('image');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/projects';
            $file->move($destination, $file_name);
            $project->image = $file_name;
        }
        if($request->file('file')){
            $file = $request->file('file');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $destination = public_path() . '/uploads/projects';
            $file->move($destination, $file_name);
            $project->file = $file_name;
        }
        $project->save();
        return response()->json(['status'=>'success','message'=>'Successfully updated'],200);
    }
    public function delete($project_id)
    {
        $p_dlt = Project::find($project_id);
        $p_dlt->delete();
        return response()->json(['status'=>'danger','message'=>'Successfully Deleted'],200);
    }

}
 