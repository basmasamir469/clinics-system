@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
    <h5 class="card-header">edit service</h5>
    <div class="card-body">
    <form method="POST" action="{{route('services.update',$service)}}" >
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>service name</label>
            <input type="text" class="form-control" name="name" value="{{$service->name}}">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>service cost</label>
            <input type="text" class="form-control" name="cost" value="{{$service->cost}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
            @error('cost')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>service type</label>
            <select name="service_type" class="form-control">
                <option value="appointments" >appoinments</option>
            </select>
            @error('service_type')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror
          </div>
          <input type="hidden" value="{{$service->id}}" name="id" class="form-control">
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
    </div>
</div>
@endsection

