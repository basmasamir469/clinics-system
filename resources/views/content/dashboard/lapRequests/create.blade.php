@extends('layouts/contentNavbarLayout')
@section('content')
<form method="POST" action="{{route('labrequests.create',['labrequest'=>$laboratory->id]))}}">
    @csrf

    <div class="form-group mb-3">
      <h4 class="card-title mb-3 mr-3">Choose Lab</h4>
         
          <select class="form-select form-select-sm" name="laboratory_id" aria-label=".form-select-sm example">
            <option value='' selected>Open this select menu</option>
            @foreach($laboratories as $laboratory)
            <option value="{{$laboratory->id}}">{{$laboratory->name}}</option>
            @endforeach
          </select>
          @error('laboratory_id')
          <small  class="form-text text-danger">{{$message}}</small>
          @enderror

    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Notes</label>
      <input type="text" class="form-control" id="exampleInputEmail1" value="" name="doctor_notes">
    </div>
    {{-- <div class="form-group">
      <label for="exampleInputE">Cost</label>
      <input type="number" class="form-control" id="exampleInputE" value="" name="cost">
    </div> --}}
    <div class="form-group">
      
      <select style="width:50%" aria-label="Default select example" name="selectedservices[]" multiple >
        <option selected>Choose Service</option>

        @foreach ($services as $service )
        <option value="{{$service->id}}">{{$service->name}}</option>
        @endforeach

      </select>
     </div>
    
     <div class="form-group">
      <div class="form-check">
        <input  class="form-check-input" type="radio" name="status" value="0" id="flexCheckDefault" checked>
        <label class="form-check-label" for="flexCheckDefault">
          reserved
        </label>
      </div>
      <div class="form-check">
        <input  class="form-check-input" type="radio" value="1" name="status" id="flexCheck">
        <label class="form-check-label" for="flexCheck">
          completed
        </label>
      </div>
      <div class="form-check">
        <input  class="form-check-input" type="radio" value="2" name="status" id="flexCheckChecked">
        <label class="form-check-label" for="flexCheckChecked">
          cancelled
        </label>
      </div>
  
     </div>

    <button type="submit" class="btn btn-primary">Lab Request</button>
  </form>

@endsection