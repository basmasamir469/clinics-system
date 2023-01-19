<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Patient;
use App\Models\Addition;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PatientRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
  function __construct()
{

 $this->middleware('permission:patient-list', ['only' => ['index']]);
 $this->middleware('permission:patient-create', ['only' => ['create','store']]);
 $this->middleware('permission:patient-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:patient-delete', ['only' => ['destroy']]);

}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $patients = Patient::latest('id')->active()->paginate(10);
    return view('content.dashboard.patients.index', compact('patients'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

    $additions = Addition::where('addition_for', 2)->get();
    $areas = Area::all();
    $insurances = Insurance::all();
    return view('content.dashboard.patients.create', compact('additions', 'areas', 'insurances'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(PatientRequest $request)
  {
    DB::connection('mysql')->beginTransaction();
    try{
    $patient=Patient::create([
      'name'=>$request->name,
      'phone'=>$request->phone,
      'date_of_birth'=>$request->date_of_birth,
      'clinic_id' => app('clinic_id'),
      'email'=>$request->email,
      'notes'=>$request->notes?$request->notes:'notes',
      'gender'=>$request->gender,
      'area_id'=>$request->area_id,
      'insurance_id'=>$request->insurance_id
  
    ]);
    
    // DB::connection('mysql')->commit();
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
  
    $additions = Addition::where('addition_for',2)->get();

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
      $patient->additions()->attach($addition,[
       // 'type'=>1,    
     //  'clinic_id'=>Auth::user()->clinic_id,
      'addvalue'=>$input]);
    }
    }
    else{
   $patient->additions()->attach($addition,[
                                         //  'type'=>1,    
                                         // 'clinic_id'=>Auth::user()->clinic_id,
                                         'addvalue'=>$addinput]);
    }    
    }
    else{
      $addinput=$request[$addition->name]?$request[$addition->name]:'';
      if(is_array($addinput)){
        foreach($addinput as $input){
        $patient->additions()->attach($addition,[
         // 'type'=>1,    
       //  'clinic_id'=>Auth::user()->clinic_id,
        'addvalue'=>$input]);
      }
      }
      else{
     $patient->additions()->attach($addition,[
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
 Alert::success( 'patient is added successfully');


    // return $addition;

    return redirect('/patients');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $Patient = Patient::find($id);
    return view('content.dashboard.patients.show', compact('Patient'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  
    $Patient = Patient::find($id);
    $areas = Area::all();
    $insurances = Insurance::all();
    $additions = Addition::where('addition_for', 2)->get();


    return view('content.dashboard.patients.edit', compact('Patient', 'areas', 'insurances','additions'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(PatientRequest $request, $id)
  {
    DB::connection('mysql')->beginTransaction();
    try{
    $Patient = Patient::find($id);
    //$Patient->name=$request->name;
    //$Patient->phone=$request->phone;
    //$Patient->email=$request->email;
    //$Patient->clinic_id=$request->clinic_id;

    $Patient->update([
      'name' => $request->name,
      'phone' => $request->phone,
      'email' => $request->email,
      'notes' => $request->notes,
      'date_of_birth' => $request->date_of_birth,
      'area_id' => $request->area_id,
      'insurance_id' => $request->insurance_id,

    ]);
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
      $Patient->additions()->detach();
      $additions = Addition::where('addition_for',2)->get();
  
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
        $Patient->additions()->attach($addition,[
         // 'type'=>1,    
       //  'clinic_id'=>Auth::user()->clinic_id,
        'addvalue'=>$input]);
      }
      }
      else{
     $Patient->additions()->attach($addition,[
                                           //  'type'=>1,    
                                           // 'clinic_id'=>Auth::user()->clinic_id,
                                           'addvalue'=>$addinput]);
      }    
      }
      else{
        $addinput=$request[$addition->name]?$request[$addition->name]:'';
        if(is_array($addinput)){
          foreach($addinput as $input){
          $Patient->additions()->attach($addition,[
           // 'type'=>1,    
         //  'clinic_id'=>Auth::user()->clinic_id,
          'addvalue'=>$input]);
        }
        }
        else{
       $Patient->additions()->attach($addition,[
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
   Alert::success( 'patient is updated successfully');
      return redirect('/patients');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //$Patient=Patient::find($id);
    //$Patient->delete();
  }
}
