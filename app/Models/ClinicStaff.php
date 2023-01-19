<?php


namespace APP\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicStaff extends Model 
{

    protected $table = 'clinic_staff';
    public $timestamps = true;

    public function clinic()
    {
        return $this->belongsTo('App/Model\Clinic');
    }

}