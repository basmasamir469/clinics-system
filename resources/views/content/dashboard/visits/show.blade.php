@extends('layouts/contentNavbarLayout')
@section('title', 'visit details')
@section('content')
<div class="card">
<h5 class="card-header">Visit Details</h5>
    <div class="card-body">
      <h3 class="card-title mb-3">Clinic Name</h3>
      <p class="card-text">{{$appointment->clinic->name}}</p>
      <h3 class="card-title mb-3">Patient Name</h3>
      <p class="card-text">{{$appointment->patient->name}}</p>

   </div>
   <h3 class="card-title mx-3">Services</h3>

   <ul class="list-group list-group-flush">

    @foreach ($appointment->services as $service)
        
        <li class="list-group-item "> {{$service->name}} --{{$service->cost}}</li>
            @endforeach
        </ul>
        <hr>
    <div class="card-body">
        <h4 class="card-title mb-3">Visit Results</h4>
        @if($appointment->visit_results)
         <p class="card-text">{{$appointment->visit_results}}</p>
         @else
         <p class="card-text">no results</p>
         @endif
         <br>
         <hr>
         <h3 class="card-title mx-1">Medicines</h3>

         <ul class="list-group list-group-flush">
      
          @foreach ($appointment->drugs as $drug)
              
              <li class="list-group-item "> {{$drug->name}} -- <span>Concentration</span>{{$drug->concentration}}</li>
                  @endforeach
              </ul>
         
   </div>
  </div>
  @endsection