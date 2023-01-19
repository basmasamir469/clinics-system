<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\usersDataTable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  function __construct()
{

 $this->middleware('permission:user-list', ['only' => ['index']]);
 $this->middleware('permission:user-create', ['only' => ['create','store']]);
 $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
 $this->middleware('permission:user-delete', ['only' => ['destroy']]);

}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

    // related => local scope to get users sharing the same clinic id that auth uses
    $users= User::related()->paginate(10);
    return view('content.dashboard.users.users',compact('users'));

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
     $roles = Role::pluck('name','name')->all();
    return view('content.dashboard.users.add',['title'=>'add new user','roles'=>$roles]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(StoreUserRequest $request)
  {
    $request['clinic_id'] = auth()->user()->clinic_id;
    $user=User::create($request->except('_token'));
     $user->assignRole($request->input('roles'));
    //  if($request->job==1){
      //  if(Permission::whereName('edit')==null||Permission::whereName('add')==null||Permission::whereName('delete')==null||Permission::whereName('view')==null){
      //    Permission::create(['name' => 'edit']);
      //    Permission::create(['name' => 'add']);
      //    Permission::create(['name' => 'delete']);
      //    Permission::create(['name' => 'view']);
      //    $user->givePermissionTo('add');
      //    $user->givePermissionTo('edit');
      //    $user->givePermissionTo('delete');
      //    $user->givePermissionTo('view');
      //  }else{
        //  $user->givePermissionTo('add');
        //  $user->givePermissionTo('edit');
        //  $user->givePermissionTo('delete');
        //  $user->givePermissionTo('view');
      //  }
    //  }elseIf($request->job==2){
      //    if(Permission::whereName('edit')==null||Permission::whereName('add')==null||Permission::whereName('delete')==null||Permission::whereName('view')==null){
      //    Permission::create(['name' => 'edit']);
      //    Permission::create(['name' => 'add']);
      //    Permission::create(['name' => 'delete']);
      //    Permission::create(['name' => 'view']);
      //    $user->givePermissionTo('add');
      //    $user->givePermissionTo('edit');
      //    $user->givePermissionTo('delete');
      //    $user->givePermissionTo('view');
      //  }else{
        //  $user->givePermissionTo('add');
        //  $user->givePermissionTo('edit');
        //  $user->givePermissionTo('delete');
        //  $user->givePermissionTo('view');
      //  }
      // }
     
    //  elseIf ($request->job==3) {
      //        if(Permission::whereName('edit')==null||Permission::whereName('add')==null||Permission::whereName('delete')==null||Permission::whereName('view')==null){
      //    Permission::create(['name' => 'edit']);
      //    Permission::create(['name' => 'add']);
      //    Permission::create(['name' => 'delete']);
      //    Permission::create(['name' => 'view']);
      //    $user->givePermissionTo('add');
      //    $user->givePermissionTo('edit');
      //    $user->givePermissionTo('delete');
      //    $user->givePermissionTo('view');
      //  }else{
        //  $user->givePermissionTo('add');
        //  $user->givePermissionTo('edit');
        //  $user->givePermissionTo('delete');
        //  $user->givePermissionTo('view');
      //  }
      //  }
    Alert::success( 'user is added successfully');
    return redirect()->route('user.index');

  }
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    dd('show');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $user=User::find($id);
     $roles = Role::pluck('name','name')->all();
     $userRole = $user->roles->pluck('name','name')->all();

    // dd($user);
    return view('content.dashboard.users.edit',['title'=>'edit user','user'=>$user,'roles'=>$roles,'userRole'=>$userRole]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id , UpdateUserRequest $request)
  {
      $user=User::find($id);
      $user->update($request->validated());
       DB::table('model_has_roles')->where('model_id',$id)->delete();
       $user->assignRole($request->input('roles'));

      Alert::success( 'user is updated successfully');
    return redirect()->route('user.index');


  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    dd('hello im destroy');
  }

}

?>
