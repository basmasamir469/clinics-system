@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">add area</h5>
  <div class="card-body">
    <form method="POST" action="{{route('areas.store')}}" >
        @csrf
        <div class="form-group">
            <label>area name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
            >
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
        <button type="submit" class="btn btn-primary mt-3">Add</button>
      </form>
  </div>
</div>
@endsection