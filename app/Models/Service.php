<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Appointment;
use App\Models\AttachService;
use App\Models\LaboratoryRequest;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'cost', 'service_type', 'clinic_id');
    protected static function booted()
    {
        static::addGlobalScope(function (Builder $builder) {
            $builder->where('clinic_id', Auth::user()->clinic->id);
        });
    }

    public function appointnemts()
    {
        return $this->belongsToMany(Appointments::class);
    }

    public function labrequests()
    {
        return $this->morphByMany(LaboratoryRequest::class, 'serviceable');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
