@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">add insurances</h5>
  <div class="card-body">
    <form method="POST" action="{{route('insurances.store')}}" >
        @csrf
          <div class="form-group">
            <label>insurance name</label>
            <input type="text" name="name" class="form-control">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    

          </div>
          <div class="form-group">
            <label>discount</label>
            <input type="text" name="discount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  class="form-control">
            @error('discount')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
  </div>
</div>
@endsection
