<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    
    //
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function rating(){
        return $this->belongsTo('App\Rating');
    }
}
