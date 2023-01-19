@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">edit medicine {{$drug->name}}</h5>
  <div class="card-body">
    <form method="POST" action="{{route('drugs.update',$drug)}}" >
        @csrf
        @method('PUT')
          <div class="form-group">
            <label>medicine name</label>
            <input type="text" name="name" value="{{$drug->name}}" class="form-control">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
          <div class="form-group">
            <label>concentration</label>
            <input type="text" name="concentration" value="{{$drug->concentration}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  class="form-control">
            @error('concentration')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">info</label>
            <textarea name="info" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$drug->info}}</textarea>
            @error('info')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
          <input type="hidden" value="{{$drug->id}}" name="id" class="form-control">
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
    </div>
</div>
@endsection