@extends('layout')
@section('content')
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">Login</h2>
            </div>
            <div class="panel-body">
                <form action="login" method="POST">
                    <div class="form-group">
                    <input class="form-control" name='username' type='text'
                        placeholder="Username">
                    </div>
                    <div class="form-group">
                    <input class="form-control" name='password' 
                        placeholder="Password" type='password'>
                    </div>
                    <input type='submit' value="Invia" 
                        class="btn btn-primary btn-block"/>
                </form>
            </div>
        </div>
    @if ($error)
        <div class='alert alert-danger'>{{{ $error }}}</div>
    @endif
    </div>
</div>
@stop
