<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //
    public function lastHit(){
        return $this->hasOne('App\Hit','application_id','id')->orderBy('id','desc');
    }
    public function logs(){
        return $this->hasMany('App\Hit','application_id','id')->orderBy('id','desc');
    }
}
