<?php

namespace App\Http\Controllers;

use App\Models\ExpenseItem;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\ExpenseItemRequest;

class ExpenseItemsController extends Controller
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
        //
        $expenseItems=ExpenseItem::paginate(10);
        return view('content.dashboard.expenseItems.index',compact('expenseItems'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    return view('content.dashboard.expenseItems.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseItemRequest $request)
    {
        //
        ExpenseItem::create([
            'name' => $request->name,
            'clinic_id' => app('clinic_id'),
          ]);
          Alert::success( 'expense item is stored successfully');
          return redirect(route('expenseItems.index'));

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
        $expenseItem=ExpenseItem::find($id);
        return view('content.dashboard.expenseItems.show',compact('expenseItem'));

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
        $expenseItem=ExpenseItem::Find($id);
        return view('content.dashboard.expenseItems.edit', compact('expenseItem'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseItemRequest $request, $id)
    {
        //
        $expenseItem=ExpenseItem::find($id);
        $expenseItem->update([
            'name' => $request->name,
            // 'clinic_id' => app('clinic_id'),
          ]);
          Alert::success( 'expense item is updated successfully');
          return redirect(route('expenseItems.index'));

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
