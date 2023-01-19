<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreServiceRequest;

class ServiceController extends Controller
{
  function __construct()
{

 $this->middleware('permission:service-list', ['only' => ['index']]);
 $this->middleware('permission:service-create', ['only' => ['create','store']]);
 $this->middleware('permission:service-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:service-delete', ['only' => ['destroy']]);

}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $services = Service::latest('id')->active()->paginate(10);
    return view('content.dashboard.services.index', compact('services'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('content.dashboard.services.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreServiceRequest $request)
  {
    $validated = $request->validated();

    Service::create([
      'name' => $validated['name'],
      'cost' => $validated['cost'],
      'clinic_id' => app('clinic_id'),
      'service_type' => $validated['service_type'],
    ]);
    Alert::success( 'service is stored successfully');

    return redirect('services');
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
  public function edit(Service $service)
  {
    return view('content.dashboard.services.edit', compact('service'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(StoreServiceRequest $request, Service $service)
  {
    $validated = $request->validated();

    $service->update([
      'name' => $validated['name'],
      'cost' => $validated['cost'],
      'clinic_id' => app('clinic_id'),
      'service_type' => $validated['service_type'],
    ]);
    Alert::success( 'service is updated successfully');
    return redirect('services');
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
