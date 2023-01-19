@extends('layouts/contentNavbarLayout')
@section('title', 'All Visits')
@section('content')
<div class="card">
<h5 class="card-header">All Visits</h5>
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

       <td><a class="btn btn-primary" href="{{route('visits.show',['visit'=>$visit->id])}}">view details</a></td>
      </tr>
      @endforeach 

    </tbody>
  </table>
</div>
</div>
@endsection