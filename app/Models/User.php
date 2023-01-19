<?php

namespace App\Models;

//  use Illuminate\Contracts\Auth\MustVerifyEmail;
use  Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Scopes\UserScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'username',
    'job',
    'active',
    'clinic_id'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  protected $table = 'users';
  public $timestamps = true;
  protected $dates = ['deleted_at'];
  // protected static function booted(){
  //     static::addGlobalScope(new UserScope);
  // }
  // public function password(): Attribute
  // {
  //     return Attribute::make(
  //         get: fn ($value) => hash::make($value),
  //         set: fn ($value) => hash::make($value),

  //     );

  // }
  public function setPasswordAttribute($password)
  {
    $this->attributes['password'] = bcrypt($password);
  }
  // public function setClinicIdAttribute($clinic_id){
  //     $this->attributes['clinic_id']=auth()->user()->clinic_id;
  // }
  public function getJobAttribute($job)
  {
    if ($job == 1) {
      return  'admin';
    } elseif ($job == 2) {
      return  'doctor';
    } elseif ($job == 3) {
      return  'assistant';
    } elseif ($job == 4) {
      return  'lab user';
    } elseif($job == 5){
      return 'pharmacist';
    }
  }
  public function getActiveValueAttribute($active)
  {
    if ($this->active == 0) {
      return  'not active';
    } elseif ($this->active == 1) {
      return  'active';
    };
  }
  public function getJobValueAttribute($job)
  {
    if ($this->job == 'admin') {
      return  '1';
    } elseif ($this->job == 'doctor') {
      return  '2';
    }elseif($this->job=='assistant'){
       return '3';
    }
     elseif ($this->job == 'lab user') {
       return  '4';
    }
    elseif($this->job == 'pharmacist'){
       return  '5';
    }
  }



  public function scopeRelated($query)
  {
    return $query->where('Clinic_id', auth::user()->clinic_id);
  }
  public function clinic()
  {
    return $this->belongsTo(Clinic::class);
  }
}
