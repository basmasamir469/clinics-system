<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Expense;
use App\Models\ExpenseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    function __construct()
    {
    
     $this->middleware('permission:expense-list', ['only' => ['index']]);
     $this->middleware('permission:expense-create', ['only' => ['create','store']]);
     $this->middleware('permission:expense-edit', ['only' => ['edit','update']]);
     $this->middleware('permission:expense-delete', ['only' => ['destroy']]);
    
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses=Expense::paginate(10);
        return view('content.dashboard.expenses.index',compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expenseItems=ExpenseItem::all();
     return view('content.dashboard.expenses.create',compact('expenseItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        Expense::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'expense_date'=>$request->expense_date?$request->expense_date:Carbon::now('Africa/Cairo')->toDateString(),
            'expense_item_id'=>$request->expense_item_id,
            'username'=>Auth::user()->name,
            'clinic_id' => app('clinic_id'),
          ]);
          Alert::success( 'expense is stored successfully');
          return redirect(route('expenses.index'));
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $expense=Expense::find($id);
        return view('content.dashboard.expenses.show',compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $expense=Expense::Find($id);
        $expenseItems=ExpenseItem::all();
        return view('content.dashboard.expenses.edit', compact('expense','expenseItems'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, $id)
    {
        //
        $expense=Expense::find($id);
        $expense->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'expense_date'=>$request->expense_date,
            'expense_item_id'=>$request->expense_item_id,
            // 'clinic_id' => app('clinic_id'),
          ]);
          Alert::success( 'expense is updated successfully');
          return redirect(route('expenses.index'));
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
