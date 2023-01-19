<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Scopes\PatientScope;
use App\Models\Addition;
use App\Models\Clinic;
use App\Models\Area;
use App\Models\Appointment;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'phone', 'date_of_birth', 'gender', 'clinic_id', 'email', 'notes', 'insurance_id', 'area_id','status');

    public function appointments()
    {
        return $this->hasMany(Appointments::class);
    }
    public function insurance()
    {
        return $this->belongsTo(insurance::class);
    }
    public function additions()
    {
        return $this->morphToMany(Addition::class, 'additionable', 'additional_values', null, 'addition_id')->withPivot('addvalue');
    }

    protected static function booted()
    {
        static::addGlobalScope(function (Builder $builder) {
            $builder->where('clinic_id', Auth::user()->clinic->id);
        });
    }
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function labrequests()
    {
        return $this->hasMany(LaboratoryRequest::class);
    }

    public function getGenderNameAttribute($val)
    {
        return $val == 0 ? 'male' : 'female';
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
