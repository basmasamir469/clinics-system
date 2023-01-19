@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card" >
    <div class="card-header">

    </div>
    <div class="card-body">
    <h1>total appointment cost</h1>
    <p>total cost : {{$total_cost}}</p>
    <p>final cost : {{ $final_cost}}</p>
    @isset($advance_payment)
    <p>advance payment : {{ $advance_payment}}</p>
    @endisset
    <p>remaining : {{ $remaining}}</p>

</div>

    <div class="card-body">
    <h1>final payments</h1>

    <p>total payment : {{ $remaining}}</p>
    @if (!$appointment->payment_transaction()->exists()) 
    <form method="POST" action="{{route('payments.store')}}" >
        @csrf
        <div class="mb-3">
            <div class="form-group">
                <input type="hidden" name="amount" class="form-control" value="{{ $remaining}}">
                <input type="hidden" name="id" class="form-control" value="{{ $id}}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add payment transaction</button>
    </form>
    @else
    <h3 style="color: green" >Payment done</h3>
    @endif


</div>
    
</div>

@endsection




