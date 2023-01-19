@extends('layouts/contentNavbarLayout')

@section('title', 'add new lap')

@section('content')
<form action="{{ route('laps.store') }} " method="post">
    @csrf
    <div class="card mb-4">
        <h5 class="card-header">add new lap</h5>
        <div class="card-body">

    <div class="mb-3">
  <label  class="form-label">name</label>
  <input type="text" class="form-control"  name="name" value="{{old('name')}}">
  @error('name')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>
<div class="mb-3">
<label  class="form-label">email</label>
  <input type="text" class="form-control"  name="email" value="{{old('email')}}">
  @error('email')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>

<div class="mb-3">
<label  class="form-label">phone</label>
  <input type="text" class="form-control"  name="phone" value="{{old('phone')}}">
  @error('phone')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>

<div class="mb-3">
<label  class="form-label">officer_in_charge</label>
  <input type="text" class="form-control"  name="officer_in_charge" value="{{old('officer_in_charge')}}">
  @error('officer_in_charge')
  <small  class="form-text text-danger">{{$message}}</small>
  @enderror    

</div>

<div class="mb-3">
<label  class="form-label">Specialization</label>
  <input type="text" class="form-control"  name="Specialization" value="{{old('Specialization')}}">
  @error('Specialization')
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
    <input type="{{$addition->addition_type}}" class="form-control"  name="{{$addition->name}}" value="{{ old($addition->name) }}">
  </div>
  @endif
  @if($addition->type===1)
     @if ($errors->has('addvalue'))
         <small  class="form-text text-danger mb-3">{{$errors->first('addvalue')}}</small>
     @endif
  @endif
@endforeach
@endif

<button type="submit" class="btn btn-primary d-block">add</button>
        </div>
    </div>
</form>
@endsection


