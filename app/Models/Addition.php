<?php

namespace App\Models;

use App\Models\Option;
use App\Models\Patient;
use App\Models\Laboratory;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addition extends Model 
{
    use HasFactory;

    protected $table = 'additions';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'addition_for', 'addition_type','clinic_id','type');
    public function getadditionForAttribute($val)
    {
      if($val==1){
         return $val = 'Appointment';
      }
      elseif($val==2){
         return $val = 'Patient';
      }elseif($val==3){
         return $val = 'Lab';
      }
    }
   //  public function getTypeAttribute($val)
   //  {
   //    if($val==0){
   //       return $val = 'optional';
   //    }
   //    elseif($val==1){
   //       return $val = 'mandatory';
   //    }
   //  }

    public function getadditionTypeAttribute($val)
   {
     if($val==1){
        return $val = 'Text';
     }elseif($val==2){
        return $val = 'Select';
     }elseif($val==3){
        return $val = 'CheckBox';
     }
   }

    public function additionable()
    {
        return $this->morphTo();
    }
   public function patients()
   {
      return $this->morphedByMany(Patient::class,'additionable','additional_values',null,'addition_id');
   }

   public function appointments()
   {
      return $this->morphedByMany(Appointment::class,'additionable','additional_values',null,'addition_id');
   }
   public function labs()
   {
      return $this->morphedByMany(Laboratory::class,'additionable','additional_values',null,'addition_id');
   }

   public function options()
   {
      return $this->hasMany(Option::class);
   }

   protected static function booted()
   {
       static::addGlobalScope(function (Builder $builder) {
           $builder->where('clinic_id', Auth::user()->clinic->id);
       });
   }



}