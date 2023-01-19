@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
<h5 class="card-header">edit appointment</h5>
    <div class="card-body">
      <form method="POST" action="{{route('appointments.update',$appointment)}}" >
        @csrf
        @method('patch')
        <div class="form-group">
          <label>Select patient</label>
            <select name="patient" class="form-control">
                @foreach ($patients as $patient)
                @if ($appointment->patient_id == $patient->id)
                <option selected value="{{$patient->id}}" >{{$patient->name}}</option>
                @endif
                <option value="{{$patient->id}}" >{{$patient->name}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Date:</label>
            <input class="form-control" value="{{$appointment->appointment_date}}" type="date" name="date">
          </div>
          <div class="form-group">
            <label>time:</label>
            <input class="form-control" value="{{$appointment->appointment_time}}" type="time" name="time">
          </div>
          <label class="form-group" > Select services: </label>

          @foreach ($services as $service)
          <div class="form-check">
            <input name="services[]" value="{{$service->id}}" class="form-check-input" type="checkbox" @if(in_array($service->id , $appointment->services()->pluck('services.id')->toArray())) checked @endif>
            <label class="form-check-label" >
              {{$service->name}}
            </label>
          </div>
          @endforeach
          <div class="form-group">
            <label>advance payment</label>
            <input type="text" value="{{$appointment->advance_payment}}" name="advance" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  class="form-control">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">notes</label>
            <textarea name="notes" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$appointment->notes}}</textarea>
          </div>
          @if($additions && $additions->count() > 0)
    @foreach($additions as $addition)
   @if($addition->addition_type=='Select')
    <div class="mb-3">
  <label  class="form-label">{{$addition->name}}</label>
    <select class="form-select" name="{{$addition->name}}" aria-label="Default select example">
      <option  selected value="">Open this select menu</option>
    @foreach($addition->options as $option)
  <option value={{$option->id}} {{-- @if($option->id==$addition->pivot->addvalue) selected @endif --}}>{{$option->value}}</option>
  @endforeach
  </select>
</div>
@elseif($addition->addition_type=='CheckBox')
<div class="mb-3">
  <label  class="form-label">{{$addition->name}}</label>
  @foreach($addition->options as $option)
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="{{$addition->name}}[]" value="{{$option->id}}" id="flexCheckDefault" 
    {{-- @if(in_array($option->id , $Patient->additions->pluck('pivot.addvalue')->toArray())) checked @endif --}}
    >
    <label class="form-check-label" for="flexCheckDefault">
      {{$option->value}}
    </label>
  </div>
  @endforeach
</div>
@else
<div class="mb-3">
  <label  class="form-label">{{$addition->name}}</label>
    <input type="{{$addition->addition_type}}" class="form-control" {{--value="{{$addition->pivot->addvalue}}"--}}  name="{{$addition->name}}">
  </div>
  @endif
  @if($addition->type===1)
  @if ($errors->has('addvalue'))
      <small  class="form-text text-danger mb-3">{{$errors->first('addvalue')}}</small>
  @endif
@endif
  @endforeach
  @endif

        <button type="submit" class="btn btn-primary d-block">Submit</button>
      </form>
    </div>
</div>
@endsection
