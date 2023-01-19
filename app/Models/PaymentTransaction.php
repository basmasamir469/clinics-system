<?php

namespace App\Models;

use App\Models\Clinic;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PaymentTransaction extends Model
{

    protected $table = 'payment_transactions';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('safe_id', 'clinic_id', 'pay_date', 'effect', 'type', 'amount');

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function paymentable()
    {
        return $this->morphTo();
    }

    protected function effect(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value == '0' ? 'income' : 'outcome',
        );
    }
}
