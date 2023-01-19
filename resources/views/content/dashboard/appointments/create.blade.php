@extends('layouts/contentNavbarLayout')
@section('content')

    <form method="POST" action="{{route('appointments.store')}}" >
        @csrf
        <div class="card">
          <div class="card-body">
            <div class="form-group">
              <label>Select patient</label>
            <select name="patient" class="form-control">
              <option selected value="">Choose patient</option>
              @foreach ($patients as $patient)
              <option value="{{$patient->id}}" >{{$patient->name}}</option>
              @endforeach
            </select>
            @error('patient')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror  
          </div>
          <div class="form-group">
            <label>Date:</label>
            <input name ="date" type="date" class ="form-control datepicker valid_to"  placeholder ="Valid To" data-date-start-date="d" value="{{date('Y-m-d', strtotime('now'))}}">
              @error('date')
              <small  class="form-text text-danger">{{$message}}</small>
              @enderror    
            </div>
          <div class="form-group">
            <label>time:</label>
              <input class="form-control" type="time" name="time" value="{{ old('time') }}">
              @error('time')
              <small  class="form-text text-danger">{{$message}}</small>
              @enderror    
            </div>
            <label class="form-group" > Select services: </label>
            @foreach ($services as $service)
        <div class="form-check">
          <input name="services[]" value="{{$service->id}}" class="form-check-input" type="checkbox">
          <label class="form-check-label" >
            {{$service->name}} -  {{$service->cost}}
          </label>
        </div>
        @endforeach
        @error('services')
        <small  class="form-text text-danger">{{$message}}</small>
        @enderror
        <div class="form-group">
          <label>advance payment</label>
          <input type="text" name="advance" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  class="form-control">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">notes</label>
            <textarea name="notes" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('notes') }}</textarea>
            @error('notes')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror  
          </div>
          @if($additions && $additions->count() > 0)
@foreach($additions as $addition)
@if($addition->addition_type=='Select')
<div class="mb-3">
  <label  class="form-label">{{$addition->name}}</label>
<select class="form-select" name={{ $addition->name }} aria-label="Default select example">
    <option  selected value="">Open this select menu</option>
    @foreach($addition->options as $option)
  <option value={{$option->id}}>{{$option->value}}</option>
  @endforeach
  </select>
</div>
@elseif($addition->addition_type=='CheckBox')
<div class="mb-3">
  <label  class="form-label">{{$addition->name}}</label>
  @foreach($addition->options as $option)
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="{{$addition->name}}[]" value="{{$option->id}}" id="flexCheckDefault">
    <label class="form-check-label" for="flexCheckDefault">
      {{$option->value}}
    </label>
  </div>
  @endforeach
</div>
@else
<div class="mb-3">
  <label  class="form-label">{{$addition->name}}</label>
    <input type="{{$addition->addition_type}}" class="form-control"  name="{{$addition->name}}" value="{{ old($addition->name)}}">
  </div>
  @endif
  @if($addition->type===1)
    @if ($errors->has('addvalue'))
      <small  class="form-text text-danger mb-3">{{$errors->first('addvalue')}}</small>
    @endif
  @endif
  @endforeach
  @endif
        <button type="submit" class="btn btn-primary d-block">Add</button>
      </form>
    </div>
    </div>
    @endsection