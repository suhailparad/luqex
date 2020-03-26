<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;
use App\Hit;
use Carbon\Carbon;
use Auth;
class HitController extends Controller
{
    //
    public function getLog($id){
        $subscriber_id=Auth::user()->subscription->id;
        $app=Application::where('id',$id)->where('subscriber_id',$subscriber_id)->first();
        $logs=$app->logs;
        return view('user.hits.index',compact('logs'));
    }   
    public function singleHit($id){
        
        $app=Application::find($id);
        $host=$app->url;
        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode==200 ){
            $hit=new Hit();
            $hit->application_id=$id;
            $hit->status="Up";
            $hit->note="Response Code : 200";
            $hit->hit_by="Self";
            $hit->save();

            $app->status=true;
            $app->save();
            return response()->json(['status'=>'success'],200);
        }else{
            $hit=new Hit();
            $hit->application_id=$id;
            $hit->status="Down";
            $hit->note="Response Code : ".$httpcode;
            $hit->hit_by="Self";
            $hit->save();

            $app->status=false;
            $app->save();
            return response()->json(['status'=>'failed','code'=>$httpcode],200);
        }
    }
}
