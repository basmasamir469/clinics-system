<?php

namespace APP\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model 
{

    protected $table = 'doctors';
    public $timestamps = true;

    public function clinic()
    {
        return $this->belongsTo('App\Models\Clinic');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment');
    }

}