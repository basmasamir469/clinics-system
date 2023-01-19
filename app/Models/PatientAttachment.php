<?php

namespace APP\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientAttachment extends Model 
{

    protected $table = 'patient_attachments';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('file_name', 'file_path', 'file_type');

}