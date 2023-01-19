<?php
namespace APP\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentService extends Model 
{

    protected $table = 'appointment_service';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('appointment_id', 'service_id', 'cost');

}