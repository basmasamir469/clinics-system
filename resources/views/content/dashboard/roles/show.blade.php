@extends('layouts/contentNavbarLayout')
@section('content')
<div class="card" >
    <div class="card-header">
        <h2> Show Role</h2>
 </div>
 <div class="card-body">
<a class="btn btn-primary mb-3" href="{{ route('roles.index') }}"> Back</a>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group mb-3">
<strong>Name:</strong>
{{ $role->name }}
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group mb-3">
<strong>Permissions:</strong>
@if(!empty($rolePermissions))
@foreach($rolePermissions as $v)
<label class="label label-success">{{ $v->name }},</label>
@endforeach
@endif
</div>
</div>
</div>
 </div>
@endsection
