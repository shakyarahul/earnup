<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Rating;
use App\Http\Resources\User as UserResource;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request == null){
           return redirect("/")->with('Error','Something went wrong');
        }else{
            $data = $request->input('skill');
            $datas = explode("~",$data);
            $user =  User::where('id','LIKE','%zxczxczxc%');
            foreach($datas as $ss){
                $user->orWhere('skills', 'LIKE', "%$ss%"); //USE OF PRIMARY AND SECONDARY OR SKILLS
            }
            $users = $user->get();
            
        }
        return UserResource::collection($users);
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
            'fname' =>'required',
            'email' => 'required',
            'location' => 'required',
            'profilePic' => 'image|nullable|max:1999'
        ]);
        
        $userInfo = User::find(auth()->user()->id);
        if(true){ //so security if needed
            //Handle File Upload
            if($request->hasFile('profilePic')){
                //Get filename with extension
                $filenameWithExt = $request->file('profilePic')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                //Get just ext
                $extension = $request->file('profilePic')->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                //Upload Image
                $path = $request->file('profilePic')->storeAs('public/cover_images',$fileNameToStore);
                $userInfo->profilePic = $fileNameToStore;
            
            }
            $userInfo->fname = $request->input('fname');
            $userInfo->lname = $request->input('lname');
            $userInfo->phone = $request->input('phone');
            $userInfo->mobile = $request->input('mobile');
            $userInfo->blockquote = $request->input('blockquote');
            $userInfo->location = $request->input('location');
            //$userInfo->email = $request->input('email');
            if(!empty($request->input('skillrequired'))){
                
                $userInfo->skills = implode("~",$request->input('skillrequired'));
            }
            $userInfo->save();
        }else{
            return redirect("/users/".auth()->user()->id."/edit")->with('Error','Something went wrong');    
        }
        
        return redirect("/users/".auth()->user()->id."/edit")->with('Success','Thank you for your time');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        $tasks = Rating::all()->where('user_id',auth()->user()->id);
        $users = User::find($id);
        $data = array(
            'tasks' => $tasks,
            'users' => $users
        );
        return view('viewuserinfo')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tasks = Rating::all()->where('user_id',auth()->user()->id);
        $data = array(
            'tasks' => $tasks,
        );
        return view('viewprofile')->with($data);
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
