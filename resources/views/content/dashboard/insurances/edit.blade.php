@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">edit insurances</h5>
  <div class="card-body">
    <form method="POST" action="{{route('insurances.update',$insurance)}}" >
      @csrf
        @method('patch')
          <div class="form-group">
            <label>insurance name</label>
            <input type="text" value="{{$insurance->name}}" name="name" class="form-control">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
          <div class="form-group">
            <label>discount</label>
            <input type="text" value="{{$insurance->insurance_discount_percentage}}" name="discount" class="form-control">
            @error('discount')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    

          </div>
          <input type="hidden" value="{{$insurance->id}}" name="id" class="form-control">
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
    </div>
</div>
@endsection