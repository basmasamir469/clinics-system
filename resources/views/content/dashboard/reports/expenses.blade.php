@extends('layouts.contentNavbarLayout')

@section('title', 'expenses Reports')
@section('content')
    <div class="card">
        <h3 class="card-header">Expenses Report</h3>


        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
            </div>
            <div class="card-body">
                <form wtx-context="E45C1219-FD11-4F9E-8306-7EA6CF6EA845" action="{{route('expense_search')}}">
                     {{-- <div class="mb-3 row">
                      <label for="html5-date-input" class="col-md-1 col-form-label">select month</label>
                      <div class="col-md-4">
                          <input class="form-control" type="month" name="month" value="" id="html5-date-input">
                      </div>
                  </div>  --}}
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

            <h5 class="card-header">Expenses Table</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-dark table-bordered">
                    <thead>
                        <tr>

                            <th>NO</th>
                            <th>Name</th>
                            <th>Cost</th>
                            <th>Date</th>
                            <th>UserName</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                          @if($expenses && $expenses->count()>0)
                        @foreach ($expenses as $expense)
                        <tr>
                            <td>{{$expense->id}}</td>
                          <td>{{$expense->name}}</td>
                          <td>{{$expense->cost}}</td>
                          <td>{{$expense->expense_date}}</td>
                          <td>{{$expense->username}}</td>
                        </tr>
                      @endforeach
                    @endif

                    </tbody>
                </table> 
                <div class="card-body links">
                    <h5 align='left'>Total expenses: <span id='total_records'>{{$total_cost}}</span></h5>
                  </div>
               
            </div>
        </div>





    </div>


@endsection

