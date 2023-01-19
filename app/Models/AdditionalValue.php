<?php

namespace APP\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Addition;

class AdditionalValue extends Model 
{

    protected $table = 'additional_values';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('type', 'additionable_id', 'addition_id', 'additionable_type', 'clinic_id');

}