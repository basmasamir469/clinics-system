@extends('layouts/contentNavbarLayout')

@section('title', 'patients table')
@section('content')
<div class="card">
    <h1 class="card-header">show patient</h1>
    <div class="table-responsive text-nowrap">
        <div class="card" style="width: 100%">
            <div class="card-body">
              <h3 class="card-title mb-3">Patient Name</h3>
              <p class="card-text">{{$Patient->name}}</p>
              <br>
              <h3 class="card-title mb-3">Patient Email</h3>
              <p class="card-text">{{$Patient->email}}</p>
              <br>
              <h4 class="card-title mb-3">Patient gender</h4>
              <p class="card-text">{{$Patient->gender}}</p>
              <br>
              <h4 class="card-title mb-3">Patient Phone</h4>
              <p class="card-text">{{$Patient->phone}}</p>
              <br>
              <h4 class="card-title mb-3">Patient date_of_birth</h4>
              <p class="card-text">{{$Patient->date_of_birth}}</p>
              <br>
              <h4 class="card-title mb-3">Patient area</h4>
              <p class="card-text">{{$Patient->area->name}}</p>
              <br>
              <h4 class="card-title mb-3">Patient insurance</h4>
              <p class="card-text">{{$Patient->insurance->name}}</p>
           </div>
        
           <ul class="list-group list-group-flush">
        
              @foreach($Patient->additions as $addition)
        
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
            <div class="card-body">
                <h4 class="card-title mb-3">Patient Notes</h4>
                 <p class="card-text">{{$Patient->notes}}</p>
                 <br>
           </div>
          </div>
    </div>
</div>
          @endsection