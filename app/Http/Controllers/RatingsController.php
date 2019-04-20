<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use App\User;
use App\Task;

class RatingsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratedId = array();
        $ratedTasks = Rating::all();
        $tasks = array();
        foreach($ratedTasks as $task){
            array_push($ratedId,$task->task_id);
            $skills = explode('~',$task->skillrequired);
            $task->skillrequired = $skills;
            if($task->user_id == auth()->user()->id){
                array_push($tasks,$task);
            }
        }
        
        $jobs = Task::all()->where('user_id',auth()->user()->id);
        $users = User::all();
        
        foreach($jobs as $job){
            
            if(in_array($job->id, $ratedId)){
                $job->skillrequired .="~rated";
            }
            $skills = explode('~',$job->skillrequired);
            $job->skillrequired = $skills;
        }

        $data = array(
            'tasks' => $tasks,
            'jobs' => $jobs,
            'users' => $users,
        );
        return view('viewtask')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'rated' =>'required',
            'userId' => 'required',
            'taskId' => 'required',
            'description' => 'required'
        ]);
        $myTask = Task::where('user_id',auth()->user()->id)->pluck('id');
        $taskId = json_decode(json_encode($myTask),true);

        if(auth()->user()->id != $request->input('userId') && in_array($request->input('taskId'),$taskId)){
            $rating = new Rating();
            $rating->rated = $request->input('rated');
            $rating->description = $request->input('description');
            $rating->task_id = $request->input('taskId');
            $rating->user_id = $request->input('userId');
            $rating->created_at = strtotime("now");
            $rating->updated_at = strtotime("now");
            $rating->save();
        }else{
            return redirect("/ratings")->with('Error','Something went wrong');    
        }
        
        return redirect("/ratings")->with('Success','Thank you for your time');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
