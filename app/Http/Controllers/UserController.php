<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=DB::table('users')
                    ->leftJoin('photos','users.photo_id','=','photos.id')
                    ->select('users.*','photos.title','photos.src','photos.description')
                    ->get();
        return $users;
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
        $validated = $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users|max:255',
            'password'=>'required',
        ]);
        $last_id=null;
        $newUser=$request->except('title','src','mime_type','alt','description');
        // return $request->only('src');
        if($request->only('src')){
            $photo=Photo::create($request->only('title','src','mime_type','alt','description'));
            $last_id=$photo->id;
            $newUser['photo_id']=$last_id;
            $user=User::create($newUser);
        }else{
            $user=User::create($newUser);
        }
        return $newUser;
        // $newUser.array_push('photo_id'=>$last_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=DB::table('users')
                    ->leftJoin('photos','users.photo_id','=','photos.id')
                    ->select('users.*','photos.title','photos.src','photos.description')
                    ->where('users.id','=',$id)
                    ->get();
        return $user;
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
        $updateUser=$request->except('title','src','mime_type','alt','description');
        $user=User::find($id);

        if($request->only('title','src','mime_type','alt','description')){
            $data=DB::table('users')
                                ->select('photo_id')
                                ->where('id','=',$id)
                                ->get();
            if($data[0]->photo_id==null){
                $photo=Photo::create($request->only('title','src','mime_type','alt','description'));
                $last_id=$photo->id;
                $updateUser['photo_id']=$last_id;

            }else{
                $photo=Photo::find($data[0]->photo_id);
                $photo->update($request->only('title','src','mime_type','alt','description'));
            }
            $user->update($updateUser);

        }
        return $updateUser;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=DB::table('users')
                            ->select('photo_id')
                            ->where('id','=',$id)
                            ->get();
        if($data[0]->photo_id!=null){
            // return ["really"=>"how"];
            User::destroy($id);
            Photo::destroy($data[0]->photo_id);
        }else{
            User::destroy($id);
        }
        return ["success"=>"user deleted successfully"];
    }
}
