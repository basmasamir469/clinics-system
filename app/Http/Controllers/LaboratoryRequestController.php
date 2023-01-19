<?php 

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Laboratory;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests\LabRequest;
use App\Models\LaboratoryRequest;
use App\Http\Requests\VisitRequest;
use App\Http\Requests\LabresultRequest;
use App\Http\Requests\LabRequestRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StorePaymenttransactionRequest;


class LaboratoryRequestController extends Controller 
{
  function __construct()
  {
  
   $this->middleware('permission:labrequest-list', ['only' => ['index']]);
   $this->middleware('permission:labrequest-create', ['only' => ['create','store']]);
   $this->middleware('permission:labrequest-edit', ['only' => ['edit','update']]);
   $this->middleware('permission:labrequest-delete', ['only' => ['destroy']]);
  
  }
  

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $requests=LaboratoryRequest::paginate(10);
    return view('content.dashboard.lapRequests.index',compact('requests'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create($id)
  {
    $appointment=Appointment::find($id);
    $laboratories=Laboratory::all();
    $services=Service::where('service_type','lab')->get();
   return view('content.dashboard.lapRequests.create',compact('appointment','laboratories','services'));

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  // public function store(LabRequestRequest $request,$id)
  // {
  //   $appointment=Appointment::find($id);
  //   $services=Service::all();
  //   $labrequest= LaboratoryRequest::create([
  //   'laboratory_id'=>$request->laboratory_id,
  //   'patient_id'=>$appointment->patient->id,
  //   'request_date'=>Carbon::now()->toDateString(),
  //   'laboratory_note'=>'notes..',
  //   'doctor_notes'=>$request->doctor_notes?$request->doctor_notes:'notes..',
  //   'cost'=>0,
  //   'status'=>$request->status,
  //   'advance_payment' => $request->advance_payment,
  //   'request_change_date'=>Carbon::now()->toDateString(),
  //   'appointment_id'=>$appointment->id
  //   ]);
    
  //   $selectedservices=$request->selectedservices;
  //   $discount = Patient::find($request->patient->id)->insurance->insurance_discount_percentage;
  //   foreach($selectedservices as $selectedService){
  //     $service=Service::find($selectedService);
  //     $labrequest->services()->attach($selectedService,['cost'=>$service->cost,'name'=>$service->name,'amount'=>$service->cost -(($service->cost * $discount) / 100)
  //   ]);
  //    }
  //   return redirect('/patiententry/'.$appointment->id)->with(['success'=>'request send successfully']);
  //   ;
  // }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $request=LaboratoryRequest::find($id);
    return view('content.dashboard.lapRequests.show',compact('request'));

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $request=LaboratoryRequest::find($id);
    $services=Service::where('service_type','lab')->get();
    return view('content.dashboard.lapRequests.edit',compact('request','services'));

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request,$id)
  {
    $services=Service::all();
    $labrequest=LaboratoryRequest::Find($id);
    $labrequest->update([
      'status'=>$request->status,
      'request_change_date'=>$request->date?$request->date:Carbon::now()->toDateString(),
    ]);
    // $selectedservices=$request->selectedservices;
    // $labrequest->services()->detach();
    $discount = Patient::find($labrequest->patient->id)->insurance->insurance_discount_percentage;
    $old_services = $labrequest->services->pluck('id')->toArray();
    $incoming_services = $request->selectedservices;

    $new_services = array_diff($incoming_services, $old_services);
    $toBeDeleted = array_diff($old_services, $incoming_services);
    $labrequest->services()->detach($toBeDeleted);
    // if($selectedservices){
    foreach($new_services as $selectedService){
      $service=Service::find($selectedService);
      $labrequest->services()->attach($selectedService,['cost'=>$service->cost,'name'=>$service->name,'amount'=>$service->cost -(($service->cost * $discount) / 100)
    ]);
     }
    // }
    Alert::success( 'lab request is updated successfully');
     return redirect('/labrequests');
}

  public function editLabResult($id)
  {
    $request= LaboratoryRequest::find($id);
    return view('content.dashboard.lapRequests.editLabResults',compact('request'));
  }

  public function updateLabResult(LabresultRequest $request,$id)
  {
    
    $filename=$this->saveImage($request->file('labresults_files'),'images/labresults');
    $labrequest=LaboratoryRequest::where('id',$id);
    $labrequest->update([
      'labresults_text'=>$request->labresults_text,
      'labresults_files'=>$filename
    ]);
    Alert::success( 'lab result is added successfully');
     return redirect('/labrequests');
  
}

public function addpayment(StorePaymenttransactionRequest $request){
    $validated = $request->validated();
    $labrequest = LaboratoryRequest::findOrFail($validated['id']);
    $labrequest->payment_transaction()->create([
      'amount' => $validated['amount'],
      'clinic_id' => app('clinic_id'),
      'pay_date' => Carbon::now(),
      'effect' => 0,
      'type' => 0,
    ]);
    Alert::success( 'payment is done');
    return redirect(route('payments.index'));

}

public function showPayment($id)
{
  $labrequest = LaboratoryRequest::where('id', $id)->first();
  $total_cost = $labrequest->services->sum('cost');
  $final_cost = $labrequest->services->sum('pivot.amount');
  $remaining = 0;
  if ($labrequest->advance_payment) {
    $remaining = $final_cost - $labrequest->advance_payment;
  } else {
    $remaining = $final_cost;
  }
  if ($labrequest->advance_payment) {
    $advance_payment = $labrequest->advance_payment;
  } else {
    $advance_payment = 0;
  }

  return view('content.dashboard.lapRequests.createPayment', compact('total_cost', 'final_cost', 'remaining', 'advance_payment', 'id','labrequest'));
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

  public function saveImage($photo,$path)
  {
    $file_extension=$photo->getClientOriginalExtension();
    $file_name=time().".".$file_extension;
    $photo->move($path,$file_name);
    return $file_name;
  }
}

?>