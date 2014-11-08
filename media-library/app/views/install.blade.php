@extends('layout')
@section('content')
<div class='panel panel-default'>
  <div class='panel-body'>
    <h2>Create admin user</h2>
    <form action=install method=POST>
      Username
      <input class='form-control' name=username placeholder=Username>
      Password
      <input class='form-control' name=password type=password>
      Confirm password
      <input class='form-control' name=passconf type=password>
      <button class='btn btn-default'>Ok</button>
    </form>
  </div>
  @if ($error)
  <div class='alert alert-danger'>{{{ $error }}}</div>
  @endif
</div>
@stop
