@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">edit area</h5>
  <div class="card-body">
    <form method="POST" action="{{route('areas.update',$area)}}" >
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>area name</label>
            <input type="hidden" name="id" value="{{$area->id}}">
            <input type="text" class="form-control" name="name" value="{{$area->name}}">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
           
          </div>
          <input type="hidden" value="{{$area->id}}" name="id" class="form-control">
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
  </div>
</div>
@endsection