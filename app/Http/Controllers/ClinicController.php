<?php 

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Appointment;
use Illuminate\Http\Request;
use DataTables;
use App\DataTables\ClinicDataTable;

class ClinicController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
   public function dtable(Request $request){

  // public function dtable(ClinicDataTable $dataTable){
  // return $dataTable->render('datatables.clinictable');
  if($request->ajax()){
  $data=Clinic::select('id','name')->get();
  return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row) {
  return $btn = '
     <a href="'.url('clinic/'.$row->id).'" class="btn btn-primary"> view apppintments </a>' ;
  })->rawColumns(['action'])->make(true);
  }
  return view('datatables.clinictable');
  }
  public function index()
  {
    
    $clinics=Clinic::clinic()->get();
    return view('clinics.index',compact('clinics'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $appointments= Appointment::where('clinic_id',$id)->get();
    return view('appointments.index',compact('appointments'));

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
  public function update($id)
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

?>