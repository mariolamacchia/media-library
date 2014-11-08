<!DOCTYPE html>
<html>
<head>
<!-- JQuery -->
<script src=" http://code.jquery.com/jquery-1.6.4.min.js" 
    type="text/javascript"></script>
<link rel="stylesheet" href="css/style.css" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" 
    href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1>Media Library <small>just a media library...</small></h1>
    </div>
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
</div>
</body>
</html>
