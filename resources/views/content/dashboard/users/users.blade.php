@extends('layouts/contentNavbarLayout')

@section('title', 'users table')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
      {{session('success')}}
    </div>
@endif
<div class="card">
  <h5 class="card-header">users</h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead class="table-light">
        <tr>
          <th>name</th>
          <th>job</th>
          <th>email</th>
          <th>username</th>
          <th>phone</th>
          <th>active</th>
           <th>Roles</th> 
          <th>action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
          @foreach ($users as $user)
          <tr>
          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$user->name}}</strong></td>
          <td>{{$user->job}}</td>
          <td>
            {{$user->email}}
          </td>
          <td>
            {{$user->username}}
          </td>
          <td>
            {{$user->phone}}
          </td>
          <td><span class="badge bg-label-primary me-1">{{$user->active_value}}</span></td>
           <td>
             @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
            <label class="badge bg-label-success">{{ $v }}</label>
            @endforeach
            @endif 
            </td> 
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="{{route("user.edit" , $user->id)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
              </div>
            </div>
          </td>
        </tr>
        @endforeach

      </tbody>
    </table>
    <div class="col-12">
      @can('user-create')

      <div class="card-body">
        {!! Form::open(array('route'=>'user.create','method'=>'get')) !!}
        <button type="submit" class="btn btn-primary">add new user</button>
        {!! Form::close() !!}
      </div>
      @endcan
      <div class="d-flex justify-content-center mt-5">
        {{$users->render()}}
      </div>
    
    </div> 
</div>
</div>
<!--/ Responsive Table -->



        @endsection
