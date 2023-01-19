@extends('layouts/contentNavbarLayout')
@section('title', 'Lab Requests')
@section('content')
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
   {{Session::get('success')}}
  </div>

 @endif
 <div class="card">
  <h5 class="card-header">Lab Requests</h5>
<table class="table table-light">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Patient Name</th>
        <th scope="col">Date</th>
        <th scope="col">LabName</th>
        <th scope="col">Services</th>
        <th scope="col">Status</th>




      </tr>
    </thead>
    <tbody>

       @foreach ($requests as $request )
      <tr>
        <th scope="row">{{$request->id}}</th>
        <td>{{$request->appointment->patient->name}}</td>
        <td>{{$request->request_date}}</td>
        <td>{{$request->laboratory->name}}</td>
       <td>
        <ul>
        @foreach ($request->services as $service )
            <li>{{$service->name}}</li>
        @endforeach
        </ul>
       </td>
       @if($request->status==="reserved")
       <td><span class="badge bg-label-primary me-1">{{$request->status}}</span></td>
       @elseif($request->status==="cancelled")
       <td><span class="badge bg-label-danger me-1">{{$request->status}}</span></td>
       @elseif($request->status==="completed")
       <td><span class="badge bg-label-success me-1">{{$request->status}}</span></td>
       @endif
         <td><a class="btn btn-secondary" href="{{route('labrequests.edit',['labrequest'=>$request->id])}}">Edit</a></td>
       <td><a class="btn btn-primary" href="{{route('labrequests.show',['labrequest'=>$request->id])}}">view details</a></td>
       <td><a class="btn btn-secondary" href="{{url('labresults/'.$request->id)}}">Add results</a></td>
       @if (!$request->payment_transaction()->exists())
      <td> <a class="btn btn-success" href="{{url('/showpayment/'.$request->id)}}"> Add payment</a><td>
        @else
        <td> <a class="btn btn-success" href="{{url('/showpayment/'.$request->id)}}"> show payment details</a><td>
        @endif
      </tr>
      @endforeach

    </tbody>
  </table>
  <div class="col-12">
    <div class="d-flex justify-content-center mt-5">
      {{$requests->render()}}
    </div>  
  </div>
  <div>
@endsection
