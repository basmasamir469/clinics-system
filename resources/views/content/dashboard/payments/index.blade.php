@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
<h5 class="card-header">Manage payments</h5>
  <table class="table">
        <thead>
          <tr>
            <th>patient name</th>
            <th>at </th>
            <th>amount</th>
            <th>effect</th>
            <th>actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($paymenttransactions as $paymenttransaction)
          <tr>
            <td>{{$paymenttransaction->paymentable->patient->name}}</td>
            <td>{{$paymenttransaction->pay_date}}</td>
            <td>{{$paymenttransaction->amount}}</td>
            <td>{{$paymenttransaction->effect}}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{route('payments.edit',$paymenttransaction)}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                </div>
              </div>
            </td>
        </tr>
        @endforeach
        </tbody>
      </table>
      <div class="col-12">
        <div class="d-flex justify-content-center mt-5">
          {{$paymenttransactions->render()}}
        </div>
      
        </div> 
      </div>
    </div>
@endsection

