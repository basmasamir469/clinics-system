<?php

namespace App\Models;
use App\Models\Addition;
use App\Models\LaboratoryRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laboratory extends Model 
{
    use HasFactory;

    protected $table = 'laboratories';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'phone', 'email', 'officer_in_charge', 'clinic_id', 'Specialization');
    public function labrequests(){
        return $this->hasMany(LaboratoryRequest::class);
    }
    public function additions()
    {
        return $this->morphToMany(Addition::class, 'additionable', 'additional_values', null, 'addition_id')->withPivot('addvalue');
    }

}