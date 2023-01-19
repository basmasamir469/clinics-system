<?php

namespace App\Http\Controllers;



use App\Models\Addition;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Label;
use App\Http\Requests\LabRequest;
use Illuminate\Support\Facades\DB;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LaboratoryController extends Controller
{
  function __construct()
{

 $this->middleware('permission:lab-list', ['only' => ['index']]);
 $this->middleware('permission:lab-create', ['only' => ['create','store']]);
 $this->middleware('permission:lab-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:lab-delete', ['only' => ['destroy']]);

}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $laps=Laboratory::paginate(10);
    return view('content.dashboard.laps.index',compact('laps'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $additions = Addition::where('addition_for', 3)->get();
    return view ('content.dashboard.laps.create',compact('additions'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(LabRequest $request)
  {
    DB::connection('mysql')->beginTransaction();
    try{
    $request['clinic_id'] = app('clinic_id');
    $lab = Laboratory::create($request->except('_token'));
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
  
        $additions = Addition::where('addition_for',3)->get();
    
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
          $lab->additions()->attach($addition,[
           // 'type'=>1,    
         //  'clinic_id'=>Auth::user()->clinic_id,
          'addvalue'=>$input]);
        }
        }
        else{
       $lab->additions()->attach($addition,[
                                             //  'type'=>1,    
                                             // 'clinic_id'=>Auth::user()->clinic_id,
                                             'addvalue'=>$addinput]);
        }    
        }
        else{
          $addinput=$request[$addition->name]?$request[$addition->name]:'';
          if(is_array($addinput)){
            foreach($addinput as $input){
            $lab->additions()->attach($addition,[
             // 'type'=>1,    
           //  'clinic_id'=>Auth::user()->clinic_id,
            'addvalue'=>$input]);
          }
          }
          else{
         $lab->additions()->attach($addition,[
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
    
     Alert::success( 'laboratory is stored successfully');
    return redirect('/laps');

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $lap=Laboratory::find($id);
    return view ('content.dashboard.laps.show',compact('lap'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $lap=Laboratory::find($id);
    $additions = Addition::where('addition_for', 3)->get();
    return view ('content.dashboard.laps.edit',compact('lap','additions'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(LabRequest $request,$id)
  {
    DB::connection('mysql')->beginTransaction();
    try{
    $lap=Laboratory::find($id);
    $lap->update([
      'name'=>$request->name,
      'phone'=>$request->phone,
      'email'=>$request->email,
      'officer_in_charge'=>$request->officer_in_charge,
      'Specialization'=>$request->Specialization,


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
      $lap->additions()->detach();
      $additions = Addition::where('addition_for',3)->get();
  
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
        $lap->additions()->attach($addition,[
         // 'type'=>1,    
       //  'clinic_id'=>Auth::user()->clinic_id,
        'addvalue'=>$input]);
      }
      }
      else{
     $lap->additions()->attach($addition,[
                                           //  'type'=>1,    
                                           // 'clinic_id'=>Auth::user()->clinic_id,
                                           'addvalue'=>$addinput]);
      }    
      }
      else{
        $addinput=$request[$addition->name]?$request[$addition->name]:'';
        if(is_array($addinput)){
          foreach($addinput as $input){
          $lap->additions()->attach($addition,[
           // 'type'=>1,    
         //  'clinic_id'=>Auth::user()->clinic_id,
          'addvalue'=>$input]);
        }
        }
        else{
       $lap->additions()->attach($addition,[
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
   Alert::success( 'laboratory is updated successfully');

    return redirect('/laps');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
     //$lap=Laboratory::find($id);
    //$lap->delete();
  }

}

?>
