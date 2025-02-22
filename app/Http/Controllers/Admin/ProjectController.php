<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Dự án';
        $projects = Project::latest()->get();
        $count_new = Ticket::where('status', 'New')->count();
      
        
        return view('backend.projects.index', compact('title', 'projects', 'count_new'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $title = 'Danh sách dự án - ADMIN';
        $projects = Project::latest()->get();
        return view('backend.projects.list',compact(
            'title','projects'
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leads(){
        $title = 'project leads';
        $projects = Project::get();
        return view('backend.projects.leads',compact(
            'title','projects'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'client' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'rate' => 'required',
            // 'rate_type' => 'required',
            'priority' => 'required',
            'leader' => 'required',
            'team' => 'required',
            'description' => 'required',
            'project_files' => 'nullable'
        ]); 
        $files = null;
        if($request->hasFile('project_files')){
            $files = array();
            foreach($request->project_files as $file){
                $fileName = time().'.'.$file->extension();
                $file->move(public_path('storage/projects/'.$request->name), $fileName);
                array_push($files,$fileName);
            }
        }
        Project::create([
            'name' => $request->name,
            'client_id' => $request->client,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'rate' => $request->rate,
            // 'rate_type' => $request->rate_type,
            'priority' => $request->priority,
            'leader' => $request->leader,
            'team' => $request->team,
            'description' => $request->description,
            'files' => $files,
            'progress' => $request->progress,
        ]);
        $notification = notify('Thêm dự án thành công');
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $project_id
     * @return \Illuminate\Http\Response
     */
    public function show($project_id)
{
    $title = 'Xem chi tiết dự án';
    $project = Project::findOrFail($project_id);
    // Lấy danh sách các nhiệm vụ của dự án
    $tasks = Ticket::where('project_id', $project_id)->get();
    return view('backend.projects.show', compact('title', 'project', 'tasks'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'client' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'rate' => 'required',
            // 'rate_type' => 'required',
            'priority' => 'required',
            'leader' => 'required',
            'team' => 'required',
            'description' => 'required',
            'project_files' => 'nullable'
        ]); 
        $project = Project::findOrfail($request->id);
        $files = $project->files;
        if($request->hasFile('project_files')){
            $files = array();
            foreach($request->project_files as $file){
                $fileName = time().'.'.$file->extension();
                $file->move(public_path('storage/projects/'), $fileName);
                array_push($files,$fileName);
            }
        }
        $project->update([
            'name' => $request->name,
            'client_id' => $request->client,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'rate' => $request->rate,
            // 'rate_type' => $request->rate_type,
            'priority' => $request->priority,
            'leader' => $request->leader,
            'team' => $request->team,
            'description' => $request->description,
            'files' => $files,
            'progress' => $request->progress,
        ]);
        $notification = notify('Cập nhật dự án thành công');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Project::findOrfail($request->id)->delete();
        $notification = notify('Xóa dự án thành công');
        return back()->with($notification);
    }
}
