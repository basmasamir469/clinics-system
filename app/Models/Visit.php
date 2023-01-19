<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model 
{

    protected $table = 'visits';
    public $timestamps = true;

    public function clinic()
    {
        return $this->belongsTo('App\Model\Clinic');
    }

    public function patient()
    {
        return $this->belongsTo('App\Model\Patient');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Model\Appointment');
    }

    public function insurance()
    {
        return $this->belongsTo('App\Model\Insurance');
    }

    public function service()
    {
        return $this->belongsTo('App\Model\Service');
    }

}