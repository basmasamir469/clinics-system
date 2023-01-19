<?php

namespace APP\Models;


use Illuminate\Database\Eloquent\Model;

class Package extends Model 
{

    protected $table = 'packages';
    public $timestamps = true;

    public function clinic()
    {
        return $this->belongsTo('App/Model\Clinic');
    }

    public function appointments()
    {
        return $this->hasMany('App/Model\Appointment');
    }

    public function patients()
    {
        return $this->hasMany('App/Model\Patient');
    }

}