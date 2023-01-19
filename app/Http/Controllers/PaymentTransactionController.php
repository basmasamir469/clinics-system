<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\PaymentTransaction;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StorePaymenttransactionRequest;
use App\Http\Requests\UpdatePaymenttransactionRequest;

class PaymentTransactionController extends Controller
{
  function __construct()
{

 $this->middleware('permission:paymenttransaction-list', ['only' => ['index']]);
 $this->middleware('permission:paymenttransaction-create', ['only' => ['create','store']]);
 $this->middleware('permission:paymenttransaction-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:paymenttransaction-delete', ['only' => ['destroy']]);

}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $paymenttransactions = PaymentTransaction::paginate(10);
    return view('content.dashboard.payments.index', compact('paymenttransactions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($id)
  {
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StorePaymenttransactionRequest $request)
  {
    $validated = $request->validated();
    $appointment = Appointment::findOrFail($validated['id']);

    $appointment->payment_transaction()->create([
      'amount' => $validated['amount'],
      'clinic_id' => app('clinic_id'),
      'pay_date' => Carbon::now(),
      'effect' => 0,
      'type' => 0,
    ]);
    Alert::success( 'payment is done');
    return redirect(route('payments.index'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $appointment = Appointment::where('id', $id)->first();
    $total_cost = $appointment->services->sum('cost');
    $final_cost = $appointment->services->sum('pivot.cost_after_insurance');
    $remaining = 0;
    if ($appointment->advance_payment) {
      $remaining = $final_cost - $appointment->advance_payment;
    } else {
      $remaining = $final_cost;
    }
    if ($appointment->advance_payment) {
      $advance_payment = $appointment->advance_payment;
    } else {
      $advance_payment = 0;
    }


    return view('content.dashboard.payments.create', compact('appointment', 'total_cost', 'final_cost', 'remaining', 'advance_payment', 'id'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(UpdatePaymenttransactionRequest $request, $id)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
  }
}
