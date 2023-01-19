<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\Expense;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
  function __construct()
  {
  
   $this->middleware('permission:expense-reports');
   $this->middleware('permission:appointment-reports');
   $this->middleware('permission:payment-reports');
   $this->middleware('permission:medicine-reports');
  
  }
  
    // appointments reports
   public function create()
  {
    $patients=Patient::all();
    $appointments=Appointment::all();
    return view ('content.dashboard.reports.appointment',compact('patients','appointments'));
  }
  public function reportsearch(Request $request){
    $appointments=Appointment::query();
        $patients=Patient::all();
      // return all status

    $appointments=$appointments->when($request->filled('status'), function ($q) {
         if(request('status')==4){
          return $q->whereIn('status', [0, 1, 2,3]);
           }
       else {
        return $q->where('status', request('status'));
           }
   })->when($request->filled('patient_id'), function ($q) {
  return $q->where('patient_id', request('patient_id'));
  })->when($request->filled('from'), function ($q) {
  return $q->where('appointment_date','>=', request('from'));
  })->when($request->filled('to'), function ($q) {
  return $q->where('appointment_date','<=', request('to'));
  })->get();

    

  return view('content.dashboard.reports.appointment',compact('appointments','patients'));

  }

  // medicines reports
  public function createMedicinesReport()
  {
    $drugs=Drug::all();
    $appointments=Appointment::whereHas('drugs')->get();
    return view ('content.dashboard.reports.medicines',compact('appointments','drugs'));
  }
  public function searchMedicines(Request $request){
    $appointments=Appointment::whereHas('drugs');
        $drugs=Drug::all();
    $appointments=$appointments->when($request->filled('medicine_id'), function ($appointments,$q) {
      $id=request('medicine_id');
       $appointments->whereHas('drugs', function($q) use ($id) {
       return $q->where('drug_id',$id );
      });
      })->when($request->filled('from'), function ($q){
      return $q->where('appointment_date','>=', request('from'));
      })->when($request->filled('to'), function ($q) {
      return $q->where('appointment_date','<=', request('to'));
     })->get();

  return view('content.dashboard.reports.medicines',compact('appointments','drugs'));

  }


  // expenses reports
  public function createExpensesReport(){
    $expenses=Expense::all();
    $total_cost = $expenses->sum('cost');
    return view ('content.dashboard.reports.expenses',compact('expenses','total_cost'));
}

public function searchexpenses(Request $request){
$expenses=Expense::query();
$expenses=$expenses->when($request->filled('from'), function ($q){
  return $q->where('expense_date','>=', request('from'));
  })->when($request->filled('to'), function ($q) {
  return $q->where('expense_date','<=', request('to'));
 })->get();

// when($request->filled('month'), function ($q) {
//    $date=explode('-',request('month'));
//     $year=$date[0];
//     $month=$date[1];  
//   return $q->whereYear('expense_date',$year)
//            ->whereMonth('expense_date',$month);
//     })->get();
    $total_cost = $expenses->sum('cost');
  return view('content.dashboard.reports.expenses',compact('expenses','total_cost'));
}

// payments reports

public function createPaymentsReport(){
  $paymenttransactions=PaymentTransaction::all();
  $total_cost = $paymenttransactions->sum('amount');
  return view ('content.dashboard.reports.payments',compact('paymenttransactions','total_cost'));
}

public function searchpayments(Request $request){
$paymenttransactions=PaymentTransaction::query();
$paymenttransactions=$paymenttransactions->when($request->filled('effect'), function ($q){
  return $q->where('effect', request('effect'));
})->when($request->filled('from'), function ($q){
  return $q->where('pay_date','>=', request('from'));
  })->when($request->filled('to'), function ($q) {
  return $q->where('pay_date','<=', request('to'));
 })->get();

$total_cost = $paymenttransactions->sum('amount');
return view('content.dashboard.reports.payments',compact('paymenttransactions','total_cost'));
}


public function createPatientsReport(){
    $appointments=Appointment::doesntHave('payment_transaction')->with('services')->get();
   $patients=Patient::all();
   return view ('content.dashboard.reports.patients',compact('appointments','patients'));
}

public function searchpatients(Request $request){

$appointments=Appointment::doesntHave('payment_transaction')->with('services');
$patients=Patient::all();
$appointments=$appointments->when($request->filled('patient_id'), function ($q) {
return $q->where('patient_id', request('patient_id'));
})->when($request->filled('from'), function ($q) {
return $q->where('appointment_date','>=', request('from'));
})->when($request->filled('to'), function ($q) {
return $q->where('appointment_date','<=', request('to'));
})->get();



return view('content.dashboard.reports.patients',compact('appointments','patients'));


}





}
