@extends('layouts/contentNavbarLayout')
@section('title', 'Edit Request')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <form method="Post" action={{route('labrequests.update',['labrequest'=>$request->id])}}>
                @csrf
                @method('PATCH')
                <div class="form-group mb-3">
                  <h5>Update status</h5>
                <div class="form-check">
                  <input @if($request->status=='reserved') checked @endif class="form-check-input" type="radio" name="status" value="0" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                    reserved
                  </label>
                </div>
                <div class="form-check">
                  <input @if($request->status=='completed') checked @endif class="form-check-input" type="radio" value="1" name="status" id="flexCheck">
                  <label class="form-check-label" for="flexCheck">
                    completed
                  </label>
                </div>
                <div class="form-check">
                  <input @if($request->status=='cancelled') checked @endif class="form-check-input" type="radio" value="2" name="status" id="flexCheckChecked">
                  <label class="form-check-label" for="flexCheckChecked">
                    cancelled
                  </label>
                </div>
              </div>
                  <div class="form-group mb-3">
                    <label class="form-group" > update services: </label>

                    @foreach ($services as $service)
                    <div class="form-check">
                      <input name="selectedservices[]" value="{{$service->id}}" class="form-check-input" type="checkbox" @if(in_array($service->id , $request->services()->pluck('services.id')->toArray())) checked @endif>
                      <label class="form-check-label" >
                        {{$service->name}}
                      </label>
                    </div>
                    @endforeach
                    @error('services')
                    <small  class="form-text text-danger">{{$message}}</small>
                    @enderror
          
                  </div>
                   <div class="form-group mb-3">
                   <label>advance payment</label>
                   <input type="text" value="{{$request->advance_payment}}" name="advance" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  class="form-control">
                 </div>
       
                 <div class="form-group mb-3">
                  <h5>Request change date</h5>
                  <input name = "date" type="date" class = "form-control datepicker valid_to" placeholder = "Valid To" data-date-start-date="d" value = "{{date('Y-m-d', strtotime('now'))}}">
                </div>
            

                
                <button type="submit" class="btn btn-primary">Update</button>
              </form>
        </div>
    </div>
</div>
</div>
@endsection