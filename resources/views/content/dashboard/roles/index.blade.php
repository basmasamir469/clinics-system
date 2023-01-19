@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card">
<div class="card-header">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
        <h2>Role Management</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
        <a class="btn btn-success mb-3" href="{{ route('roles.create') }}"> Create New Role</a>
        @endcan
        </div>
        </div>        
</div>
<div class="card-body">
<div class="table-responsive text-nowrap">
<table class="table table-bordered table-light">
<tr>
<th>No</th>
<th>Name</th>
<th width="280px">Action</th>
</tr>
@foreach ($roles as $key => $role)
<tr>
<td>{{ ++$i }}</td>
<td>{{ $role->name }}</td>
<td>
@can('role-show')
<a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
@endcan
@can('role-edit')
<a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
@endcan
{{-- {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
{!! Form::close() !!} --}}
</td>
</tr>
@endforeach
</table>
</div>
</div>
</div>
{!! $roles->render() !!}
@endsection
