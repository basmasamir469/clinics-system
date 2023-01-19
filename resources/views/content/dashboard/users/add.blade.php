@extends('layouts/contentNavbarLayout')

@section('title', 'add new user')

@section('content')

<form action="{{route('user.store')}}" method="post">
  @csrf
  <div class="card mb-4">
    <h5 class="card-header">add new user</h5>
    <div class="card-body">
      <div class="mb-3">
        <label for="defaultFormControlInput" class="form-label">Name</label>
        <input type="text" name='name' class="form-control" id="defaultFormControlInput" placeholder="enter your name" aria-describedby="defaultFormControlHelp">
        @error('name')
        <small  class="form-text text-danger">{{$message}}</small>
        @enderror

      </div>
      <div class="mb-3">
        <label for="defaultFormControlInput" class="form-label">username</label>
        <input type="text" name='username' class="form-control" id="defaultFormControlInput" placeholder="enter your username" aria-describedby="defaultFormControlHelp">
        @error('username')
        <small  class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>
      <div class="mb-3">
        <label for="defaultFormControlInput" class="form-label">phone</label>
        <input type="text" name='phone' class="form-control" id="defaultFormControlInput" placeholder="enter your phone" aria-describedby="defaultFormControlHelp">
        @error('phone')
        <small  class="form-text text-danger">{{$message}}</small>
        @enderror

      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Email address</label>
        <input type="email" name='email' class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        @error('email')
        <small  class="form-text text-danger">{{$message}}</small>
        @enderror

      </div>
      <div class="mb-3">
        <label for="exampleFormControlReadOnlyInput1" class="form-label">clinic</label>
        <input class="form-control" type="text" id="exampleFormControlReadOnlyInput1" value='{{auth()->user()->clinic->name}}' placeholder="" readonly="">
      </div>

      <div class="mb-3">
        <label for="exampleFormControlSelect1" class="form-label">job</label>
        <select class="form-select" name='job' id="exampleFormControlSelect1" aria-label="Default select example">
          <option selected="">select your job</option>
          <option value=2>doctor</option>
          <option value=3>assistant</option>
          <option value=4>lab user</option>
          <option value=5>pharmacist</option>
        </select>
        @error('job')
        <small  class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>

       <div class="form-group mb-3">
        <label class="form-label">Role:</label>
        {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
        </div> 
        
      <div class="form-password-toggle">
        <label class="form-label" for="basic-default-password32">Password</label>
        <div class="input-group input-group-merge">
          <input type="password" name='password' class="form-control" id="basic-default-password32" placeholder="············" aria-describedby="basic-default-password">
          <span class="input-group-text cursor-pointer" id="basic-default-password"><i class="bx bx-hide"></i></span>
          @error('password')
          <small  class="form-text text-danger">{{$message}}</small>
          @enderror

        </div>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">add</button>
  </div>
</form>


        @endsection
