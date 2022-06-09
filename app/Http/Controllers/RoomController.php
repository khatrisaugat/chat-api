<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use App\Models\RoomReceiver;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoomController extends Controller
{
    public function index(){
        $rooms=DB::table('rooms')
                    ->join('room_receivers','rooms.id','=','room_receivers.room_id')
                    ->select('rooms.*','room_receivers.*')
                    ->get();
        return $rooms;
    }
    public function store(Request $request){
        //validation
        $validated = $request->validate([
            'creator_id'=>'required',
            'email'=>'required|max:255',
        ]);
        //getting receiver data
        $Receiver=DB::table('users')
                        ->select('users.id','users.name')
                        ->where('email','=',$request->only('email'))
                        ->get();
        //getting creator id
        $creator=$request->only('creator_id');
        //Inserting data into rooms table
        $newRoom['name']=$Receiver[0]->name;
        $newRoom['creator_id']=intval($creator['creator_id']);
        $room=Room::insert($newRoom);
        //inserting data into RoomReceiver
        $last_id=DB::getPdo()->lastInsertId();
        $newRoomReceiver=['room_id'=>$last_id,'receiver_id'=>$Receiver[0]->id];
        $roomReceiver=RoomReceiver::insert($newRoomReceiver);
        return $last_id;
    }
    public function update(Request $request,$id){

    }
    public function show($id){
        $messages=Message::where('messages.room_id',"=",$id)
                                    // ->join('users','users.id','=','messages.sender_id')
                                    ->join('rooms','rooms.id','=','messages.room_id')
                                    ->join('room_receivers','room_receivers.room_id','=','messages.room_id')
                                    ->select('messages.*','room_receivers.receiver_id','rooms.name','rooms.creator_id')
                                    ->get();
        return $messages;
    }
    public function destroy($id){
        RoomReceiver::where('room_id','=',$id)
                        ->delete();
        Room::where('id','=',$id)
                        ->delete();
        return ["delete"=>"Success"];
    }
}
