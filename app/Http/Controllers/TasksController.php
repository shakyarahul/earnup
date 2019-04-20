<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Task;
use App\Message;
use App\User;
use App\Http\Resources\Task as TaskResource;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth',['except' => ['index']]);
    }

    public function index(Request $request)
    {
        $task = "";
        
        if($request->input('s') != null ){
            $data = $request->input('s')." ";
            $task = Task::where('jobname','LIKE',"%$data%")
            ->orWhere('jobdescription','LIKE',"%$data%")
            ->orWhere('skillrequired','LIKE',"%$data%")->paginate(10);
        }else{
            $task = Task::paginate(8);
        }
        return TaskResource::collection($task);
        
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
            'jobname' =>'required',
            'pay' => 'required',
            'skillrequired' => 'required',
            
        ]);
            if(empty($request->input('jobId'))){
                $task = new Task();
            }else{
                $task = Task::find($request->input('jobId'));
                if($task->user_id != auth()->user()->id){
                     return redirect("/ratings")->with('Error','Something went wrong');
                }
            }  

        $task->jobname = $request->input('jobname');
        $task->pay = $request->input('pay');
        $task->skillrequired = implode("~",$request->input('skillrequired'));
        $task->jobdescription = $request->input('jobdescription');;
        $task->negotiable = "1"; $request->input('negotiable');
        $task->created_at = strtotime("now");
        $task->updated_at = strtotime("now");
        $task->user_id = auth()->user()->id;
        $task->save();
        $this->sendMessageToFiveNearest($task, auth()->user()->location);
        

        return redirect("/ratings")->with('Success','Task Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $task = Task::find($id);

        //can be done with user()
            $username = User::find($task->user_id);
            $task->user_id = $username;
        //cutting down     
            $skills = explode('~',$task->skillrequired);
            $task->skillrequired = $skills;
            $success = "";
        //find suggested users
        /*
        - Show worker in recommendations from earnup as competitors to other viewer but as suggest worker for client
                ( 
                factor affecting the list.
                contain those who have been
                - match minimum of (skillrequired/3) skills of the worker
                - more familiar employee of the authenticated user i.e. employer or employee S/he have worked with/for
                - nearby the provided location in the post
                - getting the higher ratings to become suggested one
                )
         */
        //echo auth()->user()->id . "==" . $task->user_id->id;die;
        $users = DB::table('users')->select('id');
        //Find skillful worker
        foreach($skills as $skill){
                    $users->orWhere('skills', 'LIKE', "%$skill%"); //USE OF PRIMARY AND SECONDARY OR SKILLS
        }
        $suggestions = $users->get();
        $suggs = array();
        
        foreach($suggestions as $suggId){
            array_push($suggs,$suggId->id);
        }
        //Find and sort them according to their average rating
        $sortedSuggestion = DB::table('ratings')
                        ->join('users', 'ratings.user_id', '=','users.id')
                        ->select(DB::raw('
                        `user_id`,
                         avg(`rated`) AS \'average\',
                         count(`user_id`) AS \'count\',
                         `name`,
                         `profilePic`,
                         `location`
                         ')
                         )
                        ->whereIn('user_id',$suggs)
                        ->groupBy('user_id')
                        ->orderBy('average','desc')
                        ->get();
        //Find worker known by the auth user and increment their average by 1
        $sortedSuggestionIds= $sortedSuggestion->pluck('user_id');
        $peopleYouMightKnow = DB::table('ratings')
                        ->join('users', 'ratings.user_id', '=','users.id')
                        ->join('tasks', 'ratings.task_id', '=','tasks.id')
                        ->select(DB::raw(
                            ('
                            `ratings`.`user_id` AS \'user_id\',
                            avg(`rated`) AS \'average\',
                            COUNT(\'`tasks`.`user_id`\') AS \'visited\',
                            `profilePic`,
                            `name`,
                            `location`
                             ')
                            ))//jobseeker = user_id & jobgiver
                        ->where('tasks.user_id', auth()->user()->id)
                        ->whereIn('ratings.user_id', $sortedSuggestionIds)
                        ->groupBy('user_id')
                        ->orderBy('visited')
                        ->get();
        foreach($peopleYouMightKnow as $item){
            $item->average +=1;
            $sortedSuggestion->prepend($item);
        }
        //increment people with close distance by compliment of km where base is 2
        foreach($sortedSuggestion as $item){
            $latlng = explode("~",$item->location);
            $authlatlng = explode("~",auth()->user()->location);
            $d = User::distance($latlng[0], $latlng[1], $authlatlng[0], $authlatlng[1], "K");
            $item->average += (1-($d/100));
        }
        // sorted list via average
        $theSuggestedList = $sortedSuggestion->unique('user_id')->sortByDesc('average');
        /*SELECT `user_id`, avg(`rated`) AS 'average', count(`user_id`) AS 'count'  FROM `ratings` WHERE `user_id` IN (SELECT `id` FROM `users` WHERE `skills` LIKE '%Baby sitting%' OR `skills` LIKE '%Cooking%' OR `skills` LIKE '%Washing%' OR `skills` LIKE '%House wife%' OR `skills` LIKE '%Mother%') GROUP BY `user_id` ORDER BY `average` DESC
        echo "<pre>";
        print_r($sortedSuggestion->unique('user_id')->sortByDesc('average'));
        echo "<hr>";
        die;
        */
        if(!empty($request->input('involve'))){
            if($request->input('involve') == 'true'){
                //send mail to the user_id
                $success = "To - ".$task->user_id->email.
                "<br> Message - Hey I have recently seen the job listed on earnup.".
                "<br> My skills are noted down here".
                "<br> ".str_replace("~",", ",auth()->user()->skills).
                "<br>  You can called me @".auth()->user()->mobile.
                "<br>  Or mail me". auth()->user()->email;
                $acceptMsg = new Message();
                $acceptMsg->expiry = "2019-11-11";
                $acceptMsg->from_id = auth()->user()->id;
                $acceptMsg->to_id = $task->user_id->id;
                $acceptMsg->task_id = $task->id;
                $acceptMsg->message = $success;
                $acceptMsg->subject = "Acceptance for ".$task->jobname;
                $acceptMsg->save();
            }else if($request->input('involve') == 'false'){
                //send mail to the user_id
                $success = "To - ".$task->user_id->email.
                "<br> Message - Hey I have recently seen the job listed on earnup.".
                "<br> My skills are noted down here".
                "<br> ".str_replace("~",", ",auth()->user()->skills).
                "<br> I'll do it but I would like to negotiate".
                "<br>  You can called me @".auth()->user()->mobile.
                "<br>  Or mail me". auth()->user()->email;
            }else{
                
            }
        }
            $data = array(
                'id' => $id,
                'task' => $task,
                'success' => $success,
                'suggestedUsers' => $theSuggestedList,
            );
        return view('view')->with($data);
        
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
    
    public function sendMessageToFiveNearest($task,$location){
            $datas = explode("~",$task->skillrequired);
            $user =  User::where('id','LIKE','%zxczxczxc%');
            foreach($datas as $ss){
                $user->orWhere('skills', 'LIKE', "%$ss%"); //USE OF PRIMARY AND SECONDARY OR SKILLS
            }
            $users = $user->get();
            $location = explode("~",$location);
            $lat1 =$location[0];
            $lon1 =$location[1];
                
            foreach ($users as $u) {
                $locationOfUser = explode("~",$u->location);
                $lat2 = $locationOfUser[0];
                $lon2 = $locationOfUser[1];
                $u->distance = User::distance($lat1, $lon1, $lat2, $lon2, "K");
            }
            $users = $users->sortBy('distance')->slice(1,5);
            
            foreach($users as $u){
                $success = "To - ".$u->email.
                "<br> $task->jobname".
                "<br> Required Skill - ". str_replace('~',',',$task->skillrequired).
                "<br> Pay - $task->pay".
                "{!! Form::open(['id'=>'editMessage','action'=>'MessagesController@edit','enctype'=>'multipart/form-data','method'=>'POST']) !!}".
                "<button type=\"submit\">Accept</button>";

                ;
                $alertMsg = new Message();
                $alertMsg->expiry = "2019-11-11";
                $alertMsg->from_id = auth()->user()->id;
                $alertMsg->to_id = $u->id;
                $alertMsg->task_id = $task->id;
                $alertMsg->message = $success;
                $alertMsg->subject = "Alert for ".$task->jobname ;
                $alertMsg->save();
            }
    }
}
