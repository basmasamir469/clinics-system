<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use RealRashid\SweetAlert\Facades\Alert;

class AreaController extends Controller
{

  function __construct()
{

 $this->middleware('permission:area-list', ['only' => ['index']]);
 $this->middleware('permission:area-create', ['only' => ['create','store']]);
 $this->middleware('permission:area-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:area-delete', ['only' => ['destroy']]);

}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $areas = Area::paginate(10);
    return view('content.dashboard.areas.index', compact('areas'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('content.dashboard.areas.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreAreaRequest $request)
  {
    $validated = $request->validated();

    Area::create([
      'name' => $validated['name'],
      'clinic_id' => app('clinic_id'),
    ]);
    Alert::success( 'area is stored successfully');
    return redirect('areas');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show()
  {
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(Area $area)
  {
    return view('content.dashboard.areas.edit', compact('area'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(UpdateAreaRequest $request, Area $area)
  {
    $validated = $request->validated();

    $area->update([
      'name' => $validated['name'],
      'clinic_id' => app('clinic_id'),
    ]);
    Alert::success( 'area is updated successfully');
    return redirect('areas');
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
