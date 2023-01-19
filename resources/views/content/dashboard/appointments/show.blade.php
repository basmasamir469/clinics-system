@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card" >
    <div class="card-header">
        <h2>Appointment number {{$appointment->id}}  </h2>
    </div>
    <div class="card-body">

        <p> patient name : {{$appointment->patient->name}}</p>
        <p> patient insurance name : {{$appointment->patient->insurance->name}}</p>
        <p> patient insurance discount : {{$appointment->patient->insurance->insurance_discount_percentage}}</p>
        
        <h4>cost by service:</h4>
        
        @foreach ($appointment->services as $service)
        <p>service name:   {{$service->name}}</p>
        <p>service cost: {{$service->cost}}</p>
        @endforeach
        
        <h4>total cost:</h4>
        @php
            $totalcost = $appointment->services->sum('cost');
        @endphp

        <p>before insurance : {{$totalcost}}</p>
        <p>total discount : {{($totalcost * $appointment->patient->insurance->insurance_discount_percentage)  / 100}}</p>
        <p>after insurance : {{ $totalcost -( ($totalcost * $appointment->patient->insurance->insurance_discount_percentage)  / 100)}}</p>
        
        <h4 class="card-title mb-3">Visit Results</h4>
        @if($appointment->visit_results)
        <p class="card-text">{{$appointment->visit_results}}</p>
        @elseif($appointment->status==='completed')
        &nbsp;
        <a class="btn btn-secondary card-link" href="{{url('visitresults/'.$appointment->id)}}">Add results</a>
        @else
        <p class="card-text">no results</p>
        
        @endif

        <ul class="list-group list-group-flush">
        
            @foreach($appointment->additions as $addition)
      
            <h5 class="card-title mx-3 mt-3" style="text-transform:capitalize">{{$addition->name}}</h5> 
      
         {{-- to show select or checkbox value --}}
      
          {{-- first if condition --}}
      @if($addition->addition_type=='Select'|| $addition->addition_type=='CheckBox') 
      
      @foreach($addition->options as $option)
      {{-- second if condition --}}
      @if( $option->id == $addition->pivot->addvalue )
      
          <li class="list-group-item">{{$option->value}}</li>
      @endif
      {{-- end second condition --}}
      
      @endforeach
      
      {{-- if addition_type is not select or checkbox --}}
      @else
      
      <li class="list-group-item">{{$addition->pivot->addvalue}}</li>
      
      @endif
      {{-- end first condition --}}
      @endforeach    
       </ul>
    
</div>
    
</div>
@endsection




