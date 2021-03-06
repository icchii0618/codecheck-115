<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Project;

class ApiController extends Controller
{
    public function index()
    {
        $projects = new Project;
        $allProjects = $projects->all();

        if(!$allProjects) {
            return response()->json([ 'error' => 404, 'message' => 'NotFound' ], 404);
        }

        return response()->json([ 'status' => 400, 'message' => 'OK', 'results' => $allProjects]);
    }

    public function create(Request $request)
    {
        $inputs = $request->all();
        $rules = [
            'title'=>'required',
            'description'=>'required',
        ];

        $messages = [
            'title.required'=>'名前は必須です。',
            'description.required'=>'emailは必須です。',
        ];

        $validation = \Validator::make($inputs,$rules,$messages);

        if($validation->fails())
        {
            return response()->json([ 'error' => 400, 'message' => 'BadRequest' ], 400);
        }

        //$project = Project::create();
        $project = new Project;
//        if (!$request->title || !$request->description){
//            return response()->json([ 'error' => 400, 'message' => 'BadRequest' ], 400);
 //       }
        if ($request->id) {
            $project->id = $request->id;
        } 
        $project->title = $request->title;
        $project->description = $request->description;
        $project->save();

        return response()->json([ 'status' => 200, 'message' => 'OK' ], 200);
    }
    
    public function detail($id)
    {
        $project = new Project;
        $detail =  $project->findOrFail($id);

        return response()->json([ 'status' => 200, 'message' => 'OK'], 200);
    }
 
    public function delete($id)
    {
        $project = new Project;
        $targetProject = $project->findOrFail($id);
        $targetProject->delete();
        return response()->json([ 'status' => 200, 'message' => 'OK'], 200);
    }
}
