@extends('layouts/contentNavbarLayout')
@section('title', 'Add Results')
@section('content')
<form method="POST" action="{{url('labresults/'.$request->id)}}" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <input type="file" class="form-control" id="exampleInput" name="labresults_files">
        @error('labresults_files')
        <small  class="form-text text-danger">{{$message}}</small>
        @enderror
      </div>
    <div class="form-group mb-3">
      <textarea class="form-control" name="labresults_text" id="exampleFormControlTextarea1" rows="3" placeholder="add results"></textarea>
      @error('labresults_text')
          <small  class="form-text text-danger">{{$message}}</small>
          @enderror
        </div>
    <button type="submit" class="btn btn-primary">Submit</button>

  </form>

@endsection