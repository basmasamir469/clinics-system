@extends('layouts/contentNavbarLayout')

@section('title', 'edit this lap')

@section('content')
<form action="{{url('laps/'.$lap->id)}} " method="post">
    @csrf
    @method('Patch')

    <div class="mb-3">
  <label  class="form-label">name</label>
  <input type="text" class="form-control" value="{{$lap->name}}" name="name">
  @error('name')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>
<div class="mb-3">
<label  class="form-label">email</label>
  <input type="text" class="form-control" value="{{$lap->email}}" name="email">
  @error('email')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>

<div class="mb-3">
<label  class="form-label">phone</label>
  <input type="text" class="form-control" value="{{$lap->phone}}" name="phone">
  @error('phone')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>

<div class="mb-3">
<label  class="form-label">officer_in_charge</label>
  <input type="text" class="form-control" value="{{$lap->officer_in_charge}}" name="officer_in_charge">
  @error('officer_in_charge')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>
<div class="mb-3">
<label  class="form-label">Specialization</label>
  <input type="text" class="form-control" value="{{$lap->Specialization}}" name="Specialization">
  @error('Specialization')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

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

<input type="hidden" value="{{$lap->id}}" name="id" class="form-control">

<button type="submit" class="btn btn-primary d-block">update</button>
</form>
@endsection


