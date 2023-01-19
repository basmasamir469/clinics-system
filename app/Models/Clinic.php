<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Appointment;
use App\Models\PaymentTransaction;

class Clinic extends Model
{
    use HasFactory;

    protected $table = 'clinics';
    protected $fillable = [
        'name'
    ];
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }
    public function payment_transactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }
}
