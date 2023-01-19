<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;

class InsuranceController extends Controller
{
  function __construct()
{

 $this->middleware('permission:insurance-list', ['only' => ['index']]);
 $this->middleware('permission:insurance-create', ['only' => ['create','store']]);
 $this->middleware('permission:insurance-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:insurance-delete', ['only' => ['destroy']]);

}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $insurances = Insurance::paginate(10);
    return view('content.dashboard.insurances.index', compact('insurances'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('content.dashboard.insurances.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreInsuranceRequest $request)
  {
    $validated = $request->validated();
    Insurance::create([
      'name' => $validated['name'],
      'insurance_discount_percentage' => $validated['discount'],
      'patient_discount_percentage' => $validated['discount'],
    ]);
    Alert::success( 'insurance is stored successfully');
    return redirect(route('insurances.index'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(Insurance $insurance)
  {
    return view('content.dashboard.insurances.edit', compact('insurance'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(UpdateInsuranceRequest $request, Insurance $insurance)
  {
    $validated = $request->validated();
    $insurance->update([
      'name' => $validated['name'],
      'insurance_discount_percentage' => $validated['discount'],
      'patient_discount_percentage' => $validated['discount'],
    ]);
    Alert::success( 'insurance is updated successfully');
    return redirect(route('insurances.index'));
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
