@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
<h5 class="card-header">Manage medicines</h5>

    <table class="table">
        <thead>
          <tr>
            <th>name</th>
            <th>concentration</th>
            <th>info</th>
            <th>operations</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($drugs as $drug)
        <tr>
            <td>{{$drug->name}}</td>
            <td>{{$drug->concentration}} M/L</td>
            <td>{{$drug->info}}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{route('drugs.edit',$drug)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
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
        <a href="{{route('drugs.create')}}" class="btn btn-primary">add new medicine</a>
        </div>
        <div class="d-flex justify-content-center mt-5">
          {{$drugs->render()}}
      </div>
      </div>
    </div>
@endsection