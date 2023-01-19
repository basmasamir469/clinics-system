<?php

namespace App\Models;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseItem extends Model
{
    use HasFactory;
    protected $fillable = array('name', 'cost', 'clinic_id');

    public function expenses(){
        return $this->hasMany(Expense::class);
    }
}
