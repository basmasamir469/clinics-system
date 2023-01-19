<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Laboratory;
use App\Models\Appointment;
use App\Models\AttachService;
use App\Models\PaymentTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaboratoryRequest extends Model 
{

    protected $table = 'laboratory_requests';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('laboratory_id', 'patient_id', 'request_date', 'laboratory_note', 'doctor_notes', 'status', 'laboratory_service_id', 'cost', 'request_change_date', 'appointment_id','advance_payment');
    public function services(){
        return $this->morphToMany(Service::class,'serviceable','attachment_services',null,'service_id')->withPivot('cost','name','amount');
      }
      public function appointment(){
        return $this->belongsTo(Appointment::class);
      }
      public function laboratory(){
        return $this->belongsTo(Laboratory::class);
      }

      public function patient(){
        return $this->belongsTo(Patient::class);
      }


      public function getStatusAttribute($val){
        switch ($val) {
            case 0:
                # code...
                return 'reserved';
                break;
            case 1:
                return 'completed';
                break;
            case 2:
                return 'cancelled';            
                break;
        }
    }

    public function payment_transaction()
    {
        return $this->morphOne(PaymentTransaction::class, 'paymentable');
    }


}