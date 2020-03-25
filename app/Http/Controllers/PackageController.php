<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;

class PackageController extends Controller
{
    //
    public function index(){
        $packages=Package::all();
        return view('admin.packages.index',compact('packages'));
    }
    public function save(Request $request){
        $package=new Package();
        $package->name=$request->name;
        $package->description=$request->description;
        $package->price=$request->price;
        $package->save();
        return response()->json(['status'=>'success','id'=>$package->id],200);
    }
    public function update(Request $request){
        $package=Package::find($request->id);
        $package->name=$request->name;
        $package->description=$request->description;
        $package->price=$request->price;
        $package->save();
        return response()->json(['status'=>'success'],200);
    }
    public function delete(Request $request){
        $package=Package::find($request->id);
        $package->delete();
        return response()->json(['status'=>'success'],200);
    }
}
