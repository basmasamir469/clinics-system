<?php

namespace APP\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model 
{

    protected $table = 'prescriptions';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('photo', 'padding_top', 'padding_bottom', 'padding_left', 'padding_right', 'show_name', 'show_age', 'show_date', 'clinic_id');

}