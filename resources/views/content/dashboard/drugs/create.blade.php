@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">add medicine</h5>
  <div class="card-body">
    <form method="POST" action="{{route('drugs.store')}}" >
        @csrf
          <div class="form-group">
            <label>medicine name</label>
            <input type="text" name="name" value="{{old('name')}}" class="form-control">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
          <div class="form-group">
            <label>concentration</label>
            <input type="text" name="concentration" value="{{old('concentration')}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  class="form-control">
            @error('concentration')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    

          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">info</label>
            <textarea name="info" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('info') }}</textarea>
            @error('info')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    

          </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
  </div>
</div>
@endsection
