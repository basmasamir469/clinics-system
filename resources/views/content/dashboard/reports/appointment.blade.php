<?php use Carbon\Carbon; ?>
@extends('layouts.contentNavbarLayout')

@section('title', 'laboratories table')
@section('content')
    <div class="card">
        <h3 class="card-header">Appointment Report</h3>


        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
            </div>
            <div class="card-body">
                <form wtx-context="E45C1219-FD11-4F9E-8306-7EA6CF6EA845" action="{{route('report_search')}}">
                    <div class="mb-3 row">
                        <label for="defaultSelect" class=" col-md-1 col-form-label"> status:</label>
                        <div class="col-md-4">
                            <select id="defaultSelect" name="status" class="form-select">
                                <option>appointment status</option>
                                <option value="4">all</option>
                                <option value="1">done but still wait</option>
                                <option value="2">definetly done</option>
                                <option value="3">cancelled</option>
                            </select>
                        </div>
                        <label class="col-md-1 col-form-label">patient:</label>
                        <div class="col-md-4">
                            <select class="form-select" name="patient_id" aria-label="Default select example">
                                <option value="">select patient</option>
                                @foreach ($patients as $patient)
                                    <option value={{ $patient->id }}>{{ $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                      <label for="html5-date-input" class="col-md-1 col-form-label"> From :</label>
                      <div class="col-md-4">
                          {{-- <input class="form-control" type="date" name="from" value="" id="html5-date-input"> --}}
                          <input name = "from" type="date" class = "form-control datepicker valid_to" placeholder = "Valid To" data-date-start-date="d" value = "{{date('Y-m-d', strtotime('now'))}}">

                      </div>
                      <label for="html5-date-input" class="col-md-1 col-form-label"> To :</label>
                      <div class="col-md-4">
                          {{-- <input class="form-control" type="date" name="to" value="" id="html5-date-input"> --}}
                          <input name = "to" type="date" class = "form-control datepicker valid_to" placeholder = "Valid To" data-date-start-date="d" value = "{{date('Y-m-d', strtotime('now'))}}">
                      </div>
                  </div>
                  <div class="row justify-content-end">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                  </div>                </form>
            </div>
        </div>


        <div class="table-responsive text-nowrap">

            <h5 class="card-header">Appointment Report Table</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                          @if($appointments && $appointments->count()>0)
                        @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{$appointment->id}}</td>
                          <td>{{$appointment->patient->name}}</td>
                          <td>{{$appointment->appointment_date}}</td>
                          @if($appointment->status==="reserve")
                          <td><span class="badge bg-label-primary me-1">{{$appointment->status}}</span> </td>
                          @elseif($appointment->status==="cancelled")
                          <td><span class="badge badge bg-label-danger me-1">{{$appointment->status}}</span> </td>
                          @elseif($appointment->status==="confirmed")
                          <td><span class="badge bg-label-warning me-1">{{$appointment->status}}</span> </td>
                          @elseif($appointment->status==="completed")
                          <td><span class="badge bg-label-success me-1">{{$appointment->status}}</span> </td>
                          @endif
                          <td><a class="btn btn-primary" href="{{route('visits.show',['visit'=>$appointment->id])}}">view details</a></td>
                        </tr>
                      @endforeach
                    @endif



                    </tbody>
                </table>
            </div>
        </div>





    </div>


@endsection
