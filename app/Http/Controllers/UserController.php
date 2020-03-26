<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Subscriber;
use App\Hit;
class UserController extends Controller
{
    //
    public function index(){
        return view('user.dashboard.index');
    }

    //Settings
    public function getSettings(){
        return view('user.settings.index');
    }
    //Update Settings
    public function updateSettings(Request $request){
        $user=User::find(Auth::user()->id);
        $user->email=$request->email;
        $user->name=$request->name;
        if(isset($request->password))
            $user->password=bcrypt($request->password);
        $user->save();
        $profile=Subscriber::where('user_id',$user->id)->first();
        $profile->company_name=$request->company_name;
        $profile->enableSms=isset($request->smsAlert)?true:false;
        $profile->smsApi=$request->apiKey;
        $profile->senderId=$request->senderId;
        $profile->number=$request->number;
        $profile->save();
        return redirect()->back()->with("message","Settings saved successfully !!");
    }
}
