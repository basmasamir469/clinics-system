<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Drug;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Laboratory;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\LaboratoryRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VisitRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
  function __construct()
  {
  
   $this->middleware('permission:patient-entry');
   $this->middleware('permission:todayvisit-list');
  
  }
  
  private $success=true;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //all visits
        // return $visits = Appointment::where('status',2)->get();
         return view('content.dashboard.visits.todayindex');
    
    }

    public function todayvisits(Request $request)
    {

        // today visits
       $visits=Appointment::select('*')->where('status','!=',3)
        ->where(
        'appointment_date',Carbon::now('Africa/Cairo')->toDateString())
       ->paginate(10);
       return view('content.dashboard.visits.todayindex',compact('visits'));
      // if($request->ajax())
      // {
      //  $output = '';
      //  $query = $request->get('query');
      //  if($query != '')
      //  {
      //   $visits=Appointment::select('*')
      //     // ->where('status','!=',3)
      //     // ->where('appointment_date',Carbon::now()->toDateString())
      //     ->where('status', 'like', '%'.$query.'%')
      //     ->orWhere('id', 'like', '%'.$query.'%')
      //     ->orWhere('appointment_date', 'like', '%'.$query.'%')
      //     ->orderBy('id', 'desc')
      //     ->paginate(2);
          
      //  }
      //  else
      //  {
      //   $visits=Appointment::select('*')->where('status','!=',3)->where(
      //     'appointment_date',Carbon::now()->toDateString())
      //          ->paginate(2);
      //  }
      //  $total_row = $visits->count();
      //  if($total_row > 0)
      //  {
      //   foreach($visits as $row)
      //   {
      //    $output .= "
      //    <tr>
      //     <td>".$row->id."</td>
      //     <td>".$row->appointment_date."</td>
      //     <td>".$row->appointment_time."</td>
      //     <td>".$row->clinic->name."</td>
      //     <td>".$row->patient->name."</td>
      //     <td>".$row->status."</td>
      //     <td><a class='btn btn-primary' href=".url('patiententry/'.$row->id).">Patient entry</a></td>

      //    </tr>
      //    ";
      //   }
      //  }
      //  else
      //  {
      //   $output = '
      //   <tr>
      //    <td align="center" colspan="5">No Data Found</td>
      //   </tr>
      //   ';
      //  }
      //  $data = array(
      //   'table_data'  => $output,
      //   'total_data'  => $total_row,
      //   'visits'=> $visits
      //  );
 
      //  echo json_encode($data);
      // }
     }
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function updateVisit(VisitRequest $request, $id)
    {
      $appointment=Appointment::find($id);
      $appointment->update([
        'visit_results'=>$request->visit_results
      ]);
       return redirect('/patiententry/'.$appointment->id);
    }

    public function editVisit($id)
    {
      $appointment = Appointment::find($id);
      return view('appointments.editVisitResults', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // visit details

        $appointment=Appointment::find($id);
        $laboratories=Laboratory::all();
        $services=Service::where('service_type','lab')->get();
         $drugs=Drug::all();
        return view('content.dashboard.visits.show',compact('appointment','laboratories','services','drugs'));
    }

    public function patiententry($id)
    {
        // patient entry

      $appointment=Appointment::find($id);
      $laboratories=Laboratory::all();
      $services=Service::where('service_type','lab')->get();
       $drugs=Drug::all();
      return view('content.dashboard.visits.patiententry',compact('appointment','laboratories','services','drugs'));

    }

    public function entry(Request $request,$id){
        //  $appointment->update([
        //   'visit_results'=>$request->visit_results
        // ]);
        $appointment=Appointment::find($id);
        try{
         DB::transaction(function () use ($request, $appointment) {

        if($request->has('visit_results')){
        $appointment->visit_results =$request->visit_results;
        $appointment->save();
        }
          if($request->has('lapRequests')){
            // validation of lab requests
            $labrequests=$request->lapRequests;
            foreach($labrequests as $labrequest){
              $data=explode('-',$labrequest);    
             $validator=Validator::make([
              'laboratory_id'=>$data[0],
              'services'=>$data[2]
             ],[
                 'laboratory_id'=>'required',
                 'services'=>'required'
                 ]);
                 if($validator->fails()){
                    $this->success=false;
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->lapRequests);
                 } 
                }
        $labrequests=$request->lapRequests;
        foreach($labrequests as $labrequest){
          $data=explode('-',$labrequest);
          $services=Service::all();
          $laborequest= LaboratoryRequest::create([
          'laboratory_id'=>$data[0],
          'patient_id'=>$appointment->patient->id,
          'request_date'=>Carbon::now()->toDateString(),
          'laboratory_note'=>'notes..',
          'doctor_notes'=>$data[1]?$data[1]:'notes..',
          'cost'=>0,
          'status'=>0,
          'advance_payment'=>$request->advance_payment,
          'request_change_date'=>Carbon::now()->toDateString(),
          'appointment_id'=>$appointment->id
          ]);
          // dd($laborequest);
          $discount = Patient::find($appointment->patient->id)->insurance->insurance_discount_percentage;
          $selectedservices=explode(',',$data[2]);
          foreach($selectedservices as $selectedService){
            $service=Service::find($selectedService);
            $laborequest->services()->attach($selectedService,['cost'=>$service->cost,'name'=>$service->name,'amount'=>$service->cost -(($service->cost * $discount) / 100)]);
          }
          $laborequest->cost= $laborequest->services->sum('cost');
          $laborequest->save();     
       }
      
        }
        if($request->has('drugs')){
          foreach($request->drugs as $drug){
            $data=explode('-',$drug);    
           $validator=Validator::make([
            'drug_id'=>$data[0],
            'dosage'=>$data[1],
            'duration'=>$data[2]
           ],[
               'drug_id'=>'required',
               'dosage'=>'required',
               'duration'=>'required'
               ]);
               if($validator->fails()){
                  $this->success=false;
                  return redirect()->back()->withErrors($validator->errors())->withInput($request->drugs);
               } 
              }
        foreach($request->drugs as $drug){
        $old_drugs = $appointment->drugs->pluck('id')->toArray();
        $detailsofdrug=explode('-',$drug);
        $incoming_drugid = $detailsofdrug[0];
        if(in_array($incoming_drugid,$old_drugs)){
        $appointment->drugs()->detach($incoming_drugid);
          }
         $appointment->drugs()->attach($incoming_drugid,['dosage'=>$detailsofdrug[1],'duration'=>$detailsofdrug[2]]);

         }
        }
        // if($request->save=='Save'){
        //   return false;
        // }
        // else if($request->save=='Save and Done'){
        //   dd($request->save);
        //  $appointment->status=2;
        //  $appointment->save();
        // }
      });
    }
      catch (\Exception $e) {
        $this->success=false;
        return redirect()->back()->with(['error' => $e->getMessage()]);
    }
    if($request->save==='Save and Done')
    {

      $appointment->update([
        'status'=>2
      ]);
      Alert::success( 'saved successfully');
    }
    elseif( $request->save==='Save'){
      Alert::success( 'saved successfully');
     }
   return $this->success===true?redirect('/todayvisits'):redirect()->back()->with(['error'=>' Failed to save']);




       }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function search()
    // {
    //     //
    // }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
  }

