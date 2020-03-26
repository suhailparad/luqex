<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Subscriber;
use Carbon\Carbon;
use Auth;

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
        $user->password=bcrypt($request->pass);
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
        if(Auth::check() && Auth::user()->role=="subscriber")
        {
            return redirect('/user');
        }else if(Auth::check() && Auth::user()->role=="admin"){
            return redirect('/admin');
        }
        else{
            return view('auth.login');
        }
    }
    public function doLogin(Request $request){
        $user=[
            'email'=>$request->email,
            'password'=>$request->password
        ];
        // return $user;
        if(Auth::attempt($user)){
            if(Auth::user()->role=="subscriber"){
                return redirect('user');
            }else if(Auth::user()->role=="admin"){
                return redirect('admin');
            }else{
                Auth::logout();
                return redirect('login')->with('message',"Unauthorized access");;
            }
        }else{
            return redirect('login')->with('message',"Invalid email or password");;
        }
    }
    public function doLogout(){
        Auth::logout();
        return redirect('login');
    }

}
