<?php

namespace APP\Models;


use APP\Models\Addition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model 
{

    protected $table = 'options';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('value', 'clinic_id');
    
    public function addition(){
        return $this->belongsTo(Addition::class);
      }
}