@extends('dashboard.dashboard')
@section('content')
<form method="POST" action="{{url('visitresults/'.$appointment->id)}}">
    @csrf
    <div class="form-group">
      <textarea class="form-control" name="visit_results" id="exampleFormControlTextarea1" rows="3"></textarea>
      @error('visit_results')
          <small  class="form-text text-danger">{{$message}}</small>
          @enderror
        
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

  </form>

@endsection