@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
  <h5 class="card-header">edit expense Item</h5>
  <div class="card-body">
    <form method="POST" action="{{route('expenseItems.update',$expenseItem)}}" >
        @csrf
        @method('Patch')
          <div class="form-group mb-3">
            <label class="form-label">Expense_Item name</label>
            <input type="text" name="name" value="{{$expenseItem->name}}" class="form-control">
            @error('name')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror    
          </div>
          <input type="hidden" value="{{$expenseItem->id}}" name="id" class="form-control">
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
      </form>
    </div>
</div>
@endsection