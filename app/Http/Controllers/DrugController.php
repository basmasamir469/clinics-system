<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDrugRequest;
use App\Http\Requests\UpdateDrugRequest;
use RealRashid\SweetAlert\Facades\Alert;

class DrugController extends Controller
{
  function __construct()
  {
  
   $this->middleware('permission:medicine-list', ['only' => ['index']]);
   $this->middleware('permission:medicine-create', ['only' => ['create','store']]);
   $this->middleware('permission:medicine-edit', ['only' => ['edit','update']]);
   $this->middleware('permission:medicine-delete', ['only' => ['destroy']]);
  
  }
  

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $drugs = Drug::paginate(10);
    return view('content.dashboard.drugs.index', compact('drugs'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('content.dashboard.drugs.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreDrugRequest $request)
  {
    $validated = $request->validated();
    Drug::create([
      'name' => $validated['name'],
      'concentration' => $validated['concentration'],
      'info' => $validated['info'],
      'clinic_id' => app('clinic_id'),
    ]);
    Alert::success( 'medicine is stored successfully');
    return redirect(route('drugs.index'));
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
  public function edit(Drug $drug)
  {
    return view('content.dashboard.drugs.edit', compact('drug'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(UpdateDrugRequest $request, Drug $drug)
  {
    $validated = $request->validated();
    $drug->update([
      'name' => $validated['name'],
      'concentration' => $validated['concentration'],
      'info' => $validated['info'],
      'clinic_id' => app('clinic_id'),
    ]);
    Alert::success( 'medicine is updated successfully');
    return redirect(route('drugs.index'));
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
