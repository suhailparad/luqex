<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Subscriber;
use Carbon\Carbon;

class HomeController extends Controller
{
    //
    public function index(){

    }
    
    public function getRegister(){
        return view('auth.register');
    }
    public function doRegister(Request $request){
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->role="subscriber";
        $user->save();

        $subscriber=new Subscriber();
        $subscriber->company_name=$request->company;
        $subscriber->package_id=$request->package_id;
        $subscriber->user_id=$user->id;
        $now = Carbon::now();
        $subscriber->subscribed_at=$now->format('Y-m-d');
        $now->modify('next year');
        $subscriber->expire_at=$now->format('Y-m-d');
        $subscriber->save();

        return redirect('/register');
    }

    public function getLogin(){

    }
    public function doLogin(){

    }

}
