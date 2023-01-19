@extends('layouts/contentNavbarLayout')
@section('content')

<div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Addition</h3>
        </div>
        <!-- /.card-header -->
          <!-- form start -->
          <form  method="post" action="{{route('addition.update',$addition->id)}}">
            @method('PATCH')
            <div class="card-body">

              <div class="form-group mb-3">
                <label class="form-label"> Name</label>
                <input name="name" type="text" value="{{$addition->name}}" class="form-control"  placeholder="Enter Name">
              </div>
              @error('name')
              <small  class="form-text text-danger">{{$message}}</small>
              @enderror
              
              <div class="form-group mb-3">
                <label class="form-label">Addition For</label>
                <select name="addition_for" class="form-control" >
                  <option value="1" @if($addition->addition_for=="Appointment") selected @endif>Appointment</option>
                  <option value="2" @if($addition->addition_for=="Clinic") selected @endif>Patient</option>
                  <option value="3" @if($addition->addition_for=="Lab") selected @endif>Lab</option>
                </select>
              </div>
              @error('addition_for')
              <small  class="form-text text-danger">{{$message}}</small>
              @enderror

              <div class="form-group mb-3">
                <label class="form-label">Addition Type</label>
                <select id="addition" name="addition_type" class="form-control" >
                  <option value="1" @if($addition->addition_type=="Text") selected @endif>Text</option>
                  <option value="2" @if($addition->addition_type=="Select") selected @endif>Select</option>
                  <option value="3" @if($addition->addition_type=="CheckBox") selected @endif>Checkbox</option>
                </select>
              </div>
              @if($options && $options->count() > 0)
              <label class="form-label">Options</label>
              @foreach ($options as $option)
              <input class="form-control mb-3 w-25" type="text" value="{{$option->value}}" name="old_options[]">
              <input class="form-control mb-3 w-25" type="hidden" value="{{$option}}" name="old_options[]">
 
              @endforeach
              @endif
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
              <div class="form-group mb-3">
                <label class="form-label">Type</label>
                <select value="{{ old('type')}}"  name="type" class="form-control" >
                  <option selected disabled >Select validation type</option>
                  <option value="0" @if($addition->type===0) selected @endif>optional</option>
                  <option value="1" @if($addition->type===1) selected @endif>mandatory</option>
                </select>
                @error('type')
                <small  class="form-text text-danger">{{$message}}</small>
                @enderror
  
              </div>  
            </div>
            <!-- /.card-body -->
            <input type="hidden" value="{{$addition->id}}" name="id" class="form-control">
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
