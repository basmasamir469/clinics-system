<?php

namespace App\Models;

use App\Models\Drug;
use App\Models\Service;
use App\Models\Addition;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('appointment_date', 'appointment_time', 'status', 'clinic_id', 'patient_id', 'advance_payment', 'notes');

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(function (Builder $builder) {
            $builder->where('clinic_id', Auth::user()->clinic->id);
        });
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('cost', 'cost_after_insurance');
    }

    public function drugs()
    {
        return $this->belongsToMany(Drug::class)->withPivot('dosage', 'duration');;
    }

    public function payment_transaction()
    {
        return $this->morphOne(PaymentTransaction::class, 'paymentable');
    }

    public function clinic()
    {
        return $this->belongsTo('App\Models\Clinic');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Model\Doctor');
    }

    public function package()
    {
        return $this->belongsTo('App\Model\Package');
    }

    public function visit()
    {
        return $this->hasOne('App\Model\Visit');
    }

    public function getStatusAttribute($val)
    {
        switch ($val) {
            case 0:
                # code...
                return 'reserve';
                break;
            case 1:
                return 'confirmed';
                break;
            case 2:
                return 'completed';
                break;
            case 3:
                return 'cancelled';
                break;
        }
    }
    public function labrequests()
    {
        return $this->hasMany(LaboratoryRequest::class);
    }
    public function additions()
    {
        return $this->morphToMany(Addition::class, 'additionable', 'additional_values', null, 'addition_id')->withPivot('addvalue');
    }
}
