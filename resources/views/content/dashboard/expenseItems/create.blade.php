@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">add expense Items</h5>
  <div class="card-body">
    <form method="POST" action="{{route('expenseItems.store')}}" >
        @csrf
          <div class="form-group mb-3">
            <label class="form-label">Expense_Item name</label>
            <input type="text" name="name" value="{{old('name')}}" class="form-control">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
  </div>
</div>
@endsection
