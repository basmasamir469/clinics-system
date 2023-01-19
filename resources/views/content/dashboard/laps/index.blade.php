@extends('layouts/contentNavbarLayout')

@section('title', 'laboratories table')
@section('content')
<div class="card">
    <h5 class="card-header">laps</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">

            <tr>
               <th>name</th>
                <th>email</th>
                <th>phone</th>
                <th>officer_in_charge</th>
                <th>Specialization	</th>
                <th>operations</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        
            @foreach($laps as $lap)
           <tr>
        <td>  {{$lap->name}}  </td>
        <td>  {{$lap->email}}  </td>
        <td>  {{$lap->phone}}  </td>
        <td>  {{$lap->officer_in_charge}}  </td>
        <td>  {{$lap->Specialization}}  </td>
        <td><a href="{{ route('laps.show' ,$lap->id ) }}" class="btn btn-primary " tabindex="-1" role="button" aria-disabled="true">Show</a></td>
        <td><a href="{{ route('laps.edit' ,$lap->id ) }}" class="btn btn-warning" tabindex="-1" role="button" aria-disabled="true">Edit</a></td>

        
        </tr>
        @endforeach
    </tbody>
        </table>
        <div class="col-12">
            <div class="card-body">
            <a href="{{route('laps.create')}}" class="btn btn-primary">add new lap</a>
            </div>
          </div>
    </div>
</div>
        
        @endsection
        
        