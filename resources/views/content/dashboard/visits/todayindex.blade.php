@extends('layouts/contentNavbarLayout')
@section('title', 'Visits Today')
@section('content')
<div class="card">
<h5 class="card-header">Visits Today</h5>
  <div class="input-group w-50 mx-3 mb-1">
    <span class="input-group-text"><i class="tf-icons bx bx-search"></i></span>
    <input type="search" id="search" name="search" class="form-control"  placeholder="Search..." />
  </div>
<div class="table-responsive text-nowrap">
<table class="table table-light">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col">ClinicName</th>
        <th scope="col">PatientName</th>
        <th scope="col">Status</th>




      </tr>
    </thead>
    <tbody>

        @foreach ($visits as $visit )
      <tr>
        <th scope="row">{{$visit->id}}</th>
        <td>{{$visit->appointment_date}}</td>
        <td>{{$visit->appointment_time}}</td>
        <td>{{$visit->clinic->name}}</td>
        <td>{{$visit->patient->name??''}}</td>
        @if($visit->status==="reserve")
        <td><span class="badge bg-label-primary me-1">{{$visit->status}}</span></td>
        @elseif($visit->status==="cancelled")
        <td><span class="badge bg-label-danger me-1">{{$visit->status}}</span></td>
        @elseif($visit->status==="confirmed")
        <td><span class="badge bg-label-warning me-1">{{$visit->status}}</span></td>
        @elseif($visit->status==="completed")
        <td><span class="badge bg-label-success me-1">{{$visit->status}}</span></td>
        @endif

       <td><a class="btn btn-primary" href="{{url('patiententry/'.$visit->id)}}">Patient entry</a></td>
      </tr>
      @endforeach 

    </tbody>

  </table>
  <div class="card-body links">
    <h5 align="left">Total Data : <span id="total_records"></span></h5>

  </div>
  <div class="d-flex justify-content-center mt-5">
    {{$visits->render()}}
  </div>

</div>
</div>

@endsection
@section('vendor-script')
<script type="text/javascript">
$(document).ready(function(){

fetch_customer_data();

function fetch_customer_data(query = '')
{
 $.ajax({
  url:"{{ route('search')}}",
  method:'GET',
  data:{query:query},
  dataType:'json',
  success:function(data)
  {
   $('tbody').html(data.table_data);
   $('#total_records').text(data.total_data);
  }
 })
}

$(document).on('keyup', '#search', function(){
 var query = $(this).val();
 fetch_customer_data(query);
});
});
</script>
@endsection