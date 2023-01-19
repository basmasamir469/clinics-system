@extends('layouts/contentNavbarLayout')
@section('content')

@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
</div>
@endif
<div class="card">
  <h5 class="card-header">Additions</h5>
<table class="table table-light">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Addition For</th>
        <th scope="col">Addition Type</th>
       </tr>
    </thead>
    <tbody>

       @foreach ($additions as $addition )
      <tr>
        <th scope="row">{{$addition->id}}</th>
        <td>{{$addition->name}}</td>
        <td>{{$addition->addition_for}}</td>
        <td>{{$addition->addition_type}}</td>
      <td><a href="{{ route('addition.edit' ,$addition->id) }}" class="btn btn-warning" tabindex="-1" role="button" aria-disabled="true">Edit</a></td>

      </tr>
      @endforeach

    </tbody>
  </table>

  <div class="card-body">
    <a href="{{route('addition.create')}}" class="btn btn-primary"> Add New Addition</a>
  </div>
  <div class="d-flex justify-content-center mt-5">
    {{$additions->render()}}
  </div>
  <div>
@endsection

