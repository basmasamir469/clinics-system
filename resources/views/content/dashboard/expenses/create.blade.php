@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">add expenses</h5>
  <div class="card-body">
    <form method="POST" action="{{route('expenses.store')}}" >
        @csrf
        <div class="form-group mb-3">
          <label class="form-label">Select ExpenseItem</label>
            <select name="expense_item_id" class="form-control">
              <option  selected value="">Open this select menu</option>
                @foreach ($expenseItems as $expenseitem)
                <option value="{{$expenseitem->id}}" >{{$expenseitem->name}}</option>
                @endforeach
            </select>
            @error('expense_item_id')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    

          </div>
          <div class="form-group mb-3">
            <label class="form-label">expense name</label>
            <input type="text" name="name" value="{{old('name')}}" class="form-control">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
          <div class="form-group mb-3">
            <label class="form-label">cost</label>
            <input type="text" name="cost" value="{{old('cost')}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  class="form-control">
            @error('cost')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
          <div class="form-group mb-3">
            <label class="form-label">date</label>
            <input name ="expense_date" type="date" class ="form-control datepicker valid_to"  placeholder ="Valid To" data-date-start-date="d" value="{{date('Y-m-d', strtotime('now'))}}">
            @error('expense_date')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>

        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
  </div>
</div>
@endsection
