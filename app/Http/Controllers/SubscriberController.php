<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;

class SubscriberController extends Controller
{
    //
    public function index(){
        $subscribers=Subscriber::all();
        return view('admin.subscribers.index',compact('subscribers'));
    }
    public function updateStatus(Request $request){
        $subscriber=Subscriber::find($request->id);
        $subscriber->status=$request->status==1?true:false;
        $subscriber->save();
        return response()->json(['status'=>'success'],200);
    }
}
