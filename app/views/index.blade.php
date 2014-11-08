<!DOCTYPE html>
<html>
<head>
<!-- JQuery -->
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" href="css/style.css" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" 
href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js">
</script>
</head>
<body class="main-body">
<div class="container">
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <h3 class="navbar-text">Media Library</h3>
    <div class="collapse navbar-collapse">
      <div class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <span class="glyphicon glyphicon-user"></span>
          {{{ $user->username }}}
          <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="logout">Logout</a></li>
          </ul>
        </li>
      </div>
      <div class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          {{{ $downloadType }}}
          <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="?download=m3u">m3u Download</a></li>
            <li><a href="?download=ext">Video Download</a></li>
          </ul>
        </li>
      </div>
    </div>
  </nav>
  <div style=margin-top:60px>
    <h1>Media Library <small>just a media library...</small></h1>
  </div>
  @foreach($files as $file)
    <div class='col-md-3 col-sm-3'>
      <div class='thumbnail'>
        <a href='{{{ $file["link"] }}}'>
          <img src='{{{ $file["image"] }}}' alt='{{{ $file["name"] }}}'>
          <div class='caption'>{{{ $file['name'] }}}</div>
        </a>
      </div>
    </div>
  @endforeach
</div>
</div>
</body>
</html>
