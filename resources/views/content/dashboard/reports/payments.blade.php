@extends('layouts.contentNavbarLayout')

@section('title', 'payments Reports')
@section('content')
    <div class="card">
        <h3 class="card-header">Payments Report</h3>


        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
            </div>
            <div class="card-body">
                <form wtx-context="E45C1219-FD11-4F9E-8306-7EA6CF6EA845" action="{{route('payment_search')}}">
                    <div class="mb-3 row">
                        <label for="defaultSelect" class=" col-md-1 col-form-label"> effects:</label>
                        <div class="col-md-4">
                            <select id="effect"  name="effect" class="form-select">
                                <option value="">select effect</option>
                              <option value="0">income</option>
                              <option value="1">outcome</option>
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
                      <button type="submit" class="btn btn-primary search">Search</button>
                    </div>
                  </div>                </form>
            </div>
        </div>


        <div class="table-responsive text-nowrap">
            <table class="table table-dark">
                <thead>
                  <tr>
                    <th>patient name</th>
                    <th>at </th>
                    <th>amount</th>
                    <th>effect</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($paymenttransactions as $paymenttransaction)
                  <tr>
                    <td>{{$paymenttransaction->paymentable->patient->name}}</td>
                    <td>{{$paymenttransaction->pay_date}}</td>
                    <td>{{$paymenttransaction->amount}}</td>
                    <td>{{$paymenttransaction->effect}}</td>
                </tr>
                @endforeach
                </tbody>
              </table> 
        
                <div class="card-body links">
                    <h5 align='left'>Total payments: <span id='total_records'>{{$total_cost}}</span></h5>
                  </div>
               
            </div>
        </div>





    </div>


@endsection

