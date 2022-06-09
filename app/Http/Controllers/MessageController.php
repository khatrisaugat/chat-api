<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //validation
        $validated = $request->validate([
            'room_id'=>'required',
            'text'=>'required',
            'sender_id'=>'required'
        ]);
        //inserting message
        $message=Message::insert($request->all());
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $message=Message::find($id);
        $message->update($request->all());
        return $message;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Message::destroy($id);
    }

    public function getHomeScreenMesssages(){
        $messages=Message::join('rooms','messages.room_id','=','rooms.id')
                            ->join('room_receivers','messages.room_id','=','room_receivers.room_id')
                            ->select('messages.*','rooms.name as room_name','rooms.creator_id','room_receivers.receiver_id')
                            ->whereIn('messages.id',function($query){
                                $query->select(Message::raw('Max(id) as id'))
                                        ->from('messages')
                                        ->groupBy('room_id')
                                        ;
                            })
                            ->where(function($query){
                                $query->where('room_receivers.receiver_id','=',auth()->user()->id)
                                        ->orWhere('rooms.creator_id','=',auth()->user()->id);
                            })
                            // ->where('rooms.creator_id','=',auth()->user()->id)
                            // ->orWhere('room_receivers.receiver_id','=',auth()->user()->id)
                            ->get();
                            // ->toSql();
        // print($messages);
        return $messages;
    }
}
