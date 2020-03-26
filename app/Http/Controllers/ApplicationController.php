<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;
use Auth;
class ApplicationController extends Controller
{
    //
    public function index(){
        $subscriber_id=Auth::user()->subscription->id;
        $apps=Application::where("subscriber_id",$subscriber_id)->get();
        return view('user.application.index',compact('apps'));
    }

    public function save(Request $request){
        $subscriber_id=Auth::user()->subscription->id;
        $app=new Application();
        $app->title=$request->title;
        $app->url=$request->url;
        $app->subscriber_id=$subscriber_id;
        $app->enabled=$request->status=="true"?1:0;
        $app->save();
        
        return response()->json(['status'=>'success','id'=>$app->id],200);
    }
    public function update(Request $request){
        $app=Application::find($request->id);
        $app->title=$request->title;
        $app->url=$request->url;
        $app->enabled=$request->status=="true"?1:0;
        $app->save();
        return response()->json(['status'=>'success'],200);
    }
    public function delete(Request $request){
        $app=Application::find($request->id);
        $app->delete();
        return response()->json(['status'=>'success'],200);
    }
    public function toggle(Request $request){
        $app=Application::find($request->id);
        $app->enabled=!$app->enabled;
        $app->save();
        return response()->json(['status'=>'success'],200);
    }
}
