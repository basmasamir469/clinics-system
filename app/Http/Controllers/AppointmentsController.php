<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Drug;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Addition;
use App\Models\Insurance;
use App\Models\Laboratory;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VisitRequest;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\AppointmentsDataTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreAppointmentsRequest;
use App\Http\Requests\UpdateAppointmentsRequest;

class AppointmentsController extends Controller
{
  function __construct()
  {
  
   $this->middleware('permission:appointment-list', ['only' => ['index']]);
   $this->middleware('permission:appointment-create', ['only' => ['create','store']]);
   $this->middleware('permission:appointment-edit', ['only' => ['edit','update']]);
   $this->middleware('permission:appointment-delete', ['only' => ['destroy']]);
  
  }
  
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $appointments = Appointment::where('status', '0')->latest('id')->paginate(5);
    return view('content.dashboard.appointments.index', compact('appointments'));
  }

  // public function index(AppointmentsDataTable $data)
  // {
  //   return $data->render('appointments.index');
  // }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $patients = Patient::latest('id')->active()->get();
    $services = Service::latest('id')->active()->where('service_type', 'appointments')->get();
    $additions = Addition::where('addition_for', 1)->get();
    return view('content.dashboard.appointments.create', compact('patients', 'services','additions'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreAppointmentsRequest $request)
  {
    DB::connection('mysql')->beginTransaction();
    try{
    $validated = $request->validated();
    $appointment = Appointment::create([
      'appointment_date' => $validated['date'],
      'appointment_time' => $validated['time'],
      'clinic_id' => app('clinic_id'),
      'patient_id' => $validated['patient'],
      'advance_payment' => $validated['advance'],
      'notes' => $validated['notes'],
    ]);

    $discount = Patient::find($validated['patient'])->insurance->insurance_discount_percentage;

    foreach ($validated['services'] as $serviceCostid) {
      $appointment->services()->attach(
        [
          $serviceCostid => [
            'cost' => Service::find($serviceCostid)->cost,
            'cost_after_insurance' => Service::find($serviceCostid)->cost - ((Service::find($serviceCostid)->cost * $discount) / 100)
          ]
        ]
      );
    }
  }
  
  catch(ValidationException $e)
  {
    DB::connection('mysql')->rollBack();
     // Back to form with errors
     return redirect()->back()->withInput($request->all)->withErrors($e->getErrors()); // will return only the errors
    } catch(\Exception $e)
    {
      DB::connection('mysql')->rollBack();
      throw $e;
    }

    try{ 

    $additions = Addition::where('addition_for',1)->get();
    foreach($additions as $addition){
    $addinput=$request[$addition->name];

    if($addition->type===1){
        
      $validator = Validator::make(['addvalue' => $addinput]
      ,[
        'addvalue'=>'required'
       ]
      ,[
      'addvalue.required'=>'this field is required'
      ]);
    
    if($validator->fails()){
      return redirect()->back()->withInput($request->all())->withErrors($validator->errors()); // will return only the errors
    }

     if(is_array($addinput)){
       foreach($addinput as $input){
       $appointment->additions()->attach($addition,[
        // 'type'=>1,    
      //  'clinic_id'=>app('clinic_id'),
       'addvalue'=>$input]);
     }
     }
     else{
      $appointment->additions()->attach($addition,[
                                            //  'type'=>1,    
                                            // 'clinic_id'=>Auth::user()->clinic_id,
                                            'addvalue'=>$addinput]);
       }
    }

     else{
      $addinput=$request[$addition->name]?$request[$addition->name]:'';
      if(is_array($addinput)){
        foreach($addinput as $input){
        $appointment->additions()->attach($addition,[
         // 'type'=>1,    
       //  'clinic_id'=>Auth::user()->clinic_id,
        'addvalue'=>$input]);
      }
      }
     else{
    $appointment->additions()->attach($addition,[
                                          // 'type'=>1,    
                                          // 'clinic_id'=>Auth::user()->clinic_id,
                                          'addvalue'=>$addinput]);
     }
    } 
    }
   }
   catch(ValidationException $e)
   {
      // Back to form with errors
      DB::connection('mysql')->rollBack();
      return redirect()->back()->withInput($request->all)->withErrors($e->getErrors()); // will return only the errors
  
    } catch(\Exception $e)
    {
      DB::connection('mysql')->rollBack();
      throw $e;
    }
    
  
   DB::commit();
   Alert::success( 'appointment is stored successfully');
   return redirect('appointments');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(Appointment $appointment)
  {
    return view('content.dashboard.appointments.show', compact('appointment'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(Appointment $appointment)
  {
    $patients = Patient::all();
    $services = Service::where('service_type', 'appointments')->get();
    $additions = Addition::where('addition_for', 1)->get();


    return view('content.dashboard.appointments.edit', compact('patients', 'services', 'appointment','additions'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(UpdateAppointmentsRequest $request, Appointment $appointment)
  {
    DB::connection('mysql')->beginTransaction();
    try{
    $validated = $request->validated();

    $appointment->update([
      'appointment_date' => $validated['date'],
      'appointment_time' => $validated['time'],
      'clinic_id' => app('clinic_id'),
      'patient_id' => $validated['patient'],
      'advance_payment' => $validated['advance'],
      'notes' => $validated['notes'],
    ]);

    $discount = Patient::find($validated['patient'])->insurance->insurance_discount_percentage;

    $old_services = $appointment->services->pluck('id')->toArray();

    $incoming_services = $request->services;
    $new_services = array_diff($incoming_services, $old_services);
    $toBeDeleted = array_diff($old_services, $incoming_services);
    $appointment->services()->detach($toBeDeleted);
    foreach ($new_services as $serviceCostid) {
      $appointment->services()->attach(
        [
          $serviceCostid => [
            'cost' => Service::find($serviceCostid)->cost,
            'cost_after_insurance' => Service::find($serviceCostid)->cost - ((Service::find($serviceCostid)->cost * $discount) / 100)
          ]
        ]
      );
    }
   
  }
  catch(ValidationException $e)
  {
    DB::connection('mysql')->rollBack();
     // Back to form with errors
     return redirect()->back()->withInput($request->all)->withErrors($e->getErrors()); // will return only the errors
    } catch(\Exception $e)
    {
      DB::connection('mysql')->rollBack();
      throw $e;
    }
    

    try{ 
      $appointment->additions()->detach();
      $additions = Addition::where('addition_for',1)->get();
  
      foreach($additions as $addition){
      $addinput=$request[$addition->name];
      if($addition->type===1){
          
        $validator = Validator::make(['addvalue' => $addinput]
        ,[
          'addvalue'=>'required'
         ]
        ,[
        'addvalue.required'=>'this field is required'
        ]);
      
      if($validator->fails()){
        return redirect()->back()->withInput($request->all())->withErrors($validator->errors()); // will return only the errors
      }
  
      if(is_array($addinput)){
        foreach($addinput as $input){
        $appointment->additions()->attach($addition,[
         // 'type'=>1,    
       //  'clinic_id'=>Auth::user()->clinic_id,
        'addvalue'=>$input]);
      }
      }
      else{
     $appointment->additions()->attach($addition,[
                                           //  'type'=>1,    
                                           // 'clinic_id'=>Auth::user()->clinic_id,
                                           'addvalue'=>$addinput]);
      }    
      }
      else{
        $addinput=$request[$addition->name]?$request[$addition->name]:'';
        if(is_array($addinput)){
          foreach($addinput as $input){
          $appointment->additions()->attach($addition,[
           // 'type'=>1,    
         //  'clinic_id'=>Auth::user()->clinic_id,
          'addvalue'=>$input]);
        }
        }
        else{
       $appointment->additions()->attach($addition,[
                                             //  'type'=>1,    
                                             // 'clinic_id'=>Auth::user()->clinic_id,
                                             'addvalue'=>$addinput]);
        }
   
  
      }
      }
    }
   catch(ValidationException $e)
   {
      // Back to form with errors
      DB::connection('mysql')->rollBack();
      return redirect()->back()->withInput($request->all)->withErrors($e->getErrors()); // will return only the errors
  
    } catch(\Exception $e)
    {
      DB::connection('mysql')->rollBack();
      throw $e;
    }
    
  
   DB::commit();
   Alert::success( 'appointment is updated successfully');
    return redirect('appointments');
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
