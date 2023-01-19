<?php

namespace App\Models;

use App\Models\ExpenseItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = array('name', 'cost', 'expense_date','username','expense_item_id', 'clinic_id');
    public function expenseItem(){
        return $this->belongsTo(ExpenseItem::class);
    }

}
