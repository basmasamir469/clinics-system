@extends('layouts/contentNavbarLayout')

@section('title', 'edit this patient')

@section('content')
<form action="{{url('patients/'.$Patient->id)}}" method="post">
    @csrf
    @method('Patch')

<!--<div class="mb-3">
  <label  class="form-label">ID</label>
  <input type="hidden" class="form-control" value="{$Patient->id}}" name="id">
</div>-->
<div class="mb-3">
<label  class="form-label">name</label>
  <input type="text" class="form-control" value="{{$Patient->name}}" name="name">
  @error('name')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>
<div class="mb-3">
<label  class="form-label">email</label>
  <input type="text" class="form-control" value="{{$Patient->email}}" name="email">
  @error('email')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>
<div class="mb-3">
<label  class="form-label">phone</label>
  <input type="text" class="form-control" value="{{$Patient->phone}}" name="phone">
  @error('phone')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>
<div class="mb-3">
<label  class="form-label">date_of_birth</label>
  <input type="date" class="form-control" value="{{$Patient->date_of_birth}}" name="date_of_birth">
  @error('date_of_birth')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>

<div class="mb-3">
<label  class="form-label">notes</label>
  <input type="text" class="form-control" value="{{$Patient->notes}}" name="notes">
</div>

<div class="mb-3">
  <label  class="form-label">gender</label>
   <select name="gender" class="form-control">
    <option value="">please select gender</option>
    <option @if ($Patient->gender == 1) selected @endif value="1">male</option>
    <option @if ($Patient->gender == 2) selected @endif value="2">female</option>

   </select>
   @error('gender')
   <small  class="form-text text-danger">{{$message}}</small>
   @enderror    

  </div>
<div>
<label  class="form-label">area</label>
<select class="form-select" name="area_id" aria-label="Default select example">
    <option selected value="{{$Patient->area->id}}">{{$Patient->area->name}}</option>
    @foreach($areas as $area)
  <option value={{$area->id}}>{{$area->name}}</option>
  @endforeach
  </select>
  @error('area_id')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>
<div>
<label  class="form-label">insurance</label>
<select class="form-select" name="insurance_id" aria-label="Default select example">
    <option selected value="{{$Patient->insurance->id}}">{{$Patient->insurance->name}}</option>
    @foreach($insurances as $insurance)
  <option value={{$insurance->id}}>{{$insurance->name}}</option>
  @endforeach
  </select>
  @error('insurance_id')
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
  <input type="hidden" value="{{$Patient->id}}" name="id" class="form-control">

<button type="submit" class="btn btn-primary d-block">Submit</button>
</form>
@endsection

