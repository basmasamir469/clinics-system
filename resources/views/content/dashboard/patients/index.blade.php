@extends('layouts/contentNavbarLayout')

@section('title', 'patients table')
@section('content')
<div class="card">
    <h5 class="card-header">patients</h5>
    <div class="table-responsive text-nowrap">
<table class="table">
    <thead class="table-light">

    <tr>
       <th>name</th>
        <th>email</th>
        <th>phone</th>
        <th>date_of_birth</th>
        <th>notes</th>
        <th>gender</th>
        <th>area</th>
        <th>insurance</th>
        <th>operations</th>
</tr>
</thead>
<tbody class="table-border-bottom-0">
@foreach($patients as $patient)
   <tr>
<td>  {{$patient->name}}  </td>
<td>  {{$patient->email}}  </td>
<td>  {{$patient->phone}}  </td>
<td>  {{$patient->date_of_birth}}  </td>
<td>  {{$patient->notes}}  </td>
<td>  {{$patient->gender}}  </td>
<td>  {{$patient->area->name}}  </td>
<td>  {{$patient->insurance->name}}  </td>
<td><a href="{{ route('patients.show' ,$patient->id) }}" class="btn btn-primary " tabindex="-1" role="button" aria-disabled="true">Show</a></td>
<td><a href="{{ route('patients.edit' ,$patient->id) }}" class="btn btn-warning" tabindex="-1" role="button" aria-disabled="true">Edit</a></td>


</tr>
@endforeach
</tbody>
</table>
<div class="col-12">
    <div class="card-body">
    <a href="{{route('patients.create')}}" class="btn btn-primary">add new patient</a>
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{$patients->render()}}
      </div>
    
  </div>
    </div>
</div>

@endsection



