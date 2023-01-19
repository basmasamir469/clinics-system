@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
<h5 class="card-header">Manage expenses</h5>

    <table class="table">
        <thead>
          <tr>
            <th>name</th>
            <th>cost</th>
            <th>date</th>
            <th>username</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($expenses as $expense)
        <tr>
            <td>{{$expense->name}}</td>
            <td>{{$expense->cost}}</td>
            <td>{{$expense->expense_date}}</td>
            <td>{{$expense->username}}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{route('expenses.edit',$expense)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
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
        <a href="{{route('expenses.create')}}" class="btn btn-primary">add new expense</a>
        </div>
        <div class="d-flex justify-content-center mt-5">
          {{$expenses->render()}}
      </div>
      </div>
    </div>
@endsection