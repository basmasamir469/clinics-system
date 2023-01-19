@extends('layouts/contentNavbarLayout')
@section('content')

<div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">New Addition</h3>
        </div>
        <!-- /.card-header -->
          <!-- form start -->
          <form  method="post" action="{{route('addition.store')}}">
            <div class="card-body">

              <div class="form-group mb-3">
                <label class="form-label"> Name</label>
                <input name="name" type="text" value="{{ old('name')}}" class="form-control"  placeholder="Enter Name">
              </div>
              @error('name')
              <small  class="form-text text-danger">{{$message}}</small>
              @enderror

              <div class="form-group mb-3">
                <label class="form-label">Addition For</label>
                <select name="addition_for" value="{{ old('addition_for')}}" class="form-control" >
                  <option selected disabled >Select</option>
                  <option value="1">Appointment</option>
                   <option value="2">Patient</option>
                  <option value="3">Lab</option>
                </select>
              </div>
              @error('addition_for')
              <small  class="form-text text-danger">{{$message}}</small>
              @enderror
    
              <div class="form-group mb-3">
                <label class="form-label">Addition Type</label>
                <select value="{{ old('addition_type')}}" id="addition" name="addition_type" class="form-control" >
                  <option selected disabled >Select type</option>
                  <option value="1">Text</option>
                  <option value="2">Select</option>
                  <option value="3">Checkbox</option>
                </select>
              </div>
              <div class="form-group mb-3" id="options">
                @if ($errors->has('value'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <small  class="form-text text-danger">{{$errors->first('value')}}</small>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                  </button>
                 </div>
                @endif
          
              </div>
              <button type="submit" class="btn btn-secondary add-options" style="display: none">options <i class='bx bx-plus'></i></button>
              @error('addition_type')
              <small  class="form-text text-danger">{{$message}}</small>
              @enderror
            <!-- /.card-body -->
            <div class="form-group mb-3">
              <label class="form-label">Type</label>
              <select value="{{ old('type')}}"  name="type" class="form-control" >
                <option selected disabled >Select validation type</option>
                <option value="0">optional</option>
                <option value="1">mandatory</option>
              </select>
              @error('type')
              <small  class="form-text text-danger">{{$message}}</small>
              @enderror

            </div>
          </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            @csrf
          </form>
      </div>
      <!-- /.card -->

    </div>
@endsection
@section('vendor-script')
<script type="text/javascript">
                $('#addition').on('change', function() {
                  let addition_type = $("#addition option:selected").val();
                   if(addition_type=="2" || addition_type=="3" ){
                  $(".add-options").css("display", "block");
                         }
                  else{
                  $(".add-options").css("display", "none");
                }

                 });
                $(document).on('click', '.add-options', function(e) {
                  e.preventDefault();
                      $('#options').append('<input class="form-control mb-3 w-25" type="text" name="options[]">');
                          
              });
      </script>
@endsection

