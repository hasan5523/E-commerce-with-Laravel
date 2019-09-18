<?php

namespace App;
use App\User;
use App\Country;
use App\State;
use App\City;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function country(){
        return $this->belongsTo('App\Country');
    }

    public function state(){
        return $this->belongsTo('App\State');
    }

    public function city(){
        return $this->belongsTo('App\City');
    }
}
