<?php

namespace App\Models;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Drug extends Model
{

    protected $table = 'drugs';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'concentration', 'info', 'clinic_id');


    public function appointments()
    {
        return $this->belongsToMany(Appointment::class);
    }
}
