<?php 

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Addition;
 use App\DataTables\AdditionDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AdditionRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTablesDataTables;

class AdditionController extends Controller 
{
  function __construct()
{

 $this->middleware('permission:addition-list', ['only' => ['index']]);
 $this->middleware('permission:addition-create', ['only' => ['create','store']]);
 $this->middleware('permission:addition-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:addition-delete', ['only' => ['destroy']]);

}


  public function index()
  {
  $additions=Addition::paginate(10);
  return view('content.dashboard.addition.index',compact('additions'));
  }
  
 
 
  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('content.dashboard.addition.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(AdditionRequest $request)
  {  
      DB::beginTransaction();
     $addition=Addition::create([
      'name'=>$request->name,
      'addition_for'=>$request->addition_for,
      'addition_type'=>$request->addition_type,
      'type'=>$request->type,
      'clinic_id'=>app('clinic_id')
     ]);
     if($request->options && count($request->options) > 0){
   foreach ($request->options as $option) {
    $validator=Validator::make([
      'value'=>$option
    ],[
      'value' => 'required|unique:options,value,null,null,addition_id,'.$addition->id.',clinic_id,'.app('clinic_id'),
         ],[
          'value.required'=>'this option value is required',
          'value.unique'=>'this option value is already taken'
         ]);
         if($validator->fails()){
          DB::rollback();
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
         }
               
    $newoption= new Option();
    $newoption->addition_id=$addition->id;
    $newoption->value=$option;
    $newoption->clinic_id=app('clinic_id');
    $newoption->save();
       }
      }
      DB::commit();
      Alert::success( 'addition is stored successfully');
    return redirect('addition');
  }

  
 public function show()
  {
  # code...
}
  

  public function edit(Addition $addition)
  {
    $options=Option::where('addition_id',$addition->id)->get();
    return view ('content.dashboard.addition.edit' ,compact('addition','options'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(AdditionRequest $request ,Addition $addition)
  {
    DB::beginTransaction();
    $addition->update($request->validated());
    $old_options=$request->old_options;
    // check if there are old options to update
    if($old_options && count($old_options) > 0){
      foreach ($old_options as $key => $option) {
        $option=json_decode($option);
        // check option if is not null
        if($option){
          $validator=Validator::make([
            'value'=>$old_options[$key-1]
             ],[
            'value' => 'required|unique:options,value,'.$option->id.',id,addition_id,'.$addition->id.',clinic_id,'.app('clinic_id'),
               ],[
                'value.required'=>'this option value is required',
                'value.unique'=>'this option value is already taken'
               ]);
               if($validator->fails()){
                DB::rollback();
                return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
               }     
  
           $newoption=Option::where('id',$option->id)->first();
           $newoption->value=$old_options[$key-1];
           $newoption->save();
        }
          }
        }
      // check if there are new options to add
    if($request->options && count($request->options) > 0){
        foreach ($request->options as $option) {
          $validator=Validator::make([
            'value'=>$option
             ],[
            'value' => 'required|unique:options,value,null,null,addition_id,'.$addition->id.',clinic_id,'.app('clinic_id'),
               ],[
                'value.required'=>'this option value is required',
                'value.unique'=>'this option value is already taken'
               ]);
               if($validator->fails()){
                DB::rollback();
                  return redirect()->back()->withErrors($validator->errors())->withInput($request->all);
               }     

       $newoption= new Option();
       $newoption->addition_id=$addition->id;
       $newoption->value=$option;
       $newoption->clinic_id=app('clinic_id');
       $newoption->save();
          }
        }
    DB::commit();
    Alert::success( 'addition is updated successfully');
    return redirect('addition');
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

?>