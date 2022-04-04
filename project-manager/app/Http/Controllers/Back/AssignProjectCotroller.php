<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class AssignProjectCotroller extends Controller
{
    public function viewAssign(){

    	$users = User::where('type', 'admin')->get();
    	$projects = Project::get();
        return view('back.assign.assign_project',compact('users','projects'));
    }
    public function viewAssignUser($project_id){
    	$project = Project::with('section')->where('id',$project_id)->first();

    	dd($project);

    	return view('back.assign.assign_user',compact('project'));
    }
}
