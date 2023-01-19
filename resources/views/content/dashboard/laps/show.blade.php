@extends('layouts/contentNavbarLayout')

@section('title', 'laboratories table')
@section('content')
<div class="card">
    <h1 class="card-header">show lap</h1>
    <div class="table-responsive text-nowrap">
        <div class="card" style="width: 100%">
            <div class="card-body">
              <h3 class="card-title mb-3">Lap Name</h3>
              <p class="card-text">{{$lap->name}}</p>
              <br>
              <h3 class="card-title mb-3">Lap Email</h3>
              <p class="card-text">{{$lap->email}}</p>
              <br>
              <h4 class="card-title mb-3">Lap Phone</h4>
              <p class="card-text">{{$lap->phone}}</p>
              <br>
              <h4 class="card-title mb-3">Lap officer_in_charge</h4>
              <p class="card-text">{{$lap->officer_in_charge}}</p>
              <br>
              <h4 class="card-title mb-3">Lap Specialization</h4>
              <p class="card-text">{{$lap->Specialization}}</p>
           </div>
           <ul class="list-group list-group-flush">
        
            @foreach($lap->additions as $addition)
      
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