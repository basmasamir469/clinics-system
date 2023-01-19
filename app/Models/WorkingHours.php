<?php

namespace APP\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkingHours extends Model 
{

    protected $table = 'working_hours';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('day', 'working_hours', 'from', 'to');

}