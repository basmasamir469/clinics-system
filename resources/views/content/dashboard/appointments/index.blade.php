@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
<h5 class="card-header">Manage appointments</h5>
<table class="table">
        <thead>
          <tr>
            <th>No.</th>
            <th>patient name</th>
            <th>in </th>
            <th>at </th>
            <th>status</th>
            <th>notes</th>
            <th>services</th>
            <th>services cost</th>
            <th>actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
          <tr>
            <td><a href="{{route('appointments.show',$appointment)}}">{{$loop->iteration}}</a></td>
            <td>{{$appointment->patient->name}}</td>
            <td>{{$appointment->appointment_date}}</td>
            <td>{{$appointment->appointment_time}}</td>
            @if($appointment->status==="reserve")
            <td><span class="badge bg-label-primary me-1">{{$appointment->status}}</span> </td>
            @elseif($appointment->status==="cancelled")
            <td><span class="badge badge bg-label-danger me-1">{{$appointment->status}}</span> </td>
            @elseif($appointment->status==="confirmed")
            <td><span class="badge bg-label-warning me-1">{{$appointment->status}}</span> </td>
            @elseif($appointment->status==="completed")
            <td><span class="badge bg-label-success me-1">{{$appointment->status}}</span> </td>
            @endif
       
            <td>{{$appointment->notes}}</td>
            <td>
            @foreach ($appointment->services as $service)
            <ul>
                <li>
                    {{$service->name}}

                </li>    
            </ul>
            @endforeach
            </td>
            <td>
            @foreach ($appointment->services as $service)
            <ul>
                <li>

                    {{$service->pivot->cost}}
                </li>    
            </ul>
            @endforeach
            </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{route('appointments.edit',$appointment)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  @if (!$appointment->payment_transaction()->exists())
                  <a class="dropdown-item" href="{{route('payments.show',$appointment->id)}}"><i class="bx bx-edit-alt me-1"></i> Add payment</a>
                  @else
                  <a class="dropdown-item" href="{{route('payments.show',$appointment->id)}}"><i class="bx bx-dollar me-1"></i> show payment</a>
                  @endif
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                </div>
              </div>
            </td>
        </tr>
        @endforeach
        </tbody>
      </table> 
      <div class="col-12">
        <div class="card-body">
        <a href="{{route('appointments.create')}}" class="btn btn-primary">add new appointment</a>
        </div>
        <div class="d-flex justify-content-center mt-5">
          {{$appointments->render()}}
      </div>
      </div>
    </div>
@endsection

{{-- toast fail try  --}}
{{-- 
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template-free/demo/assets/js/ui-toasts.js"></script>
<script>
  @if(Session::has('message'))
  var type = "{{ Session::get('alert-type','info') }}"
  switch(type){
     case 'info':
     toastr.info(" {{ Session::get('message') }} ");
     break;
 
     case 'success':
     toastr.success(" {{ Session::get('message') }} ");
     break;
 
     case 'warning':
     toastr.warning(" {{ Session::get('message') }} ");
     break;
 
     case 'error':
     toastr.error(" {{ Session::get('message') }} ");
     break; 
  }
  @endif 
 </script> --}}