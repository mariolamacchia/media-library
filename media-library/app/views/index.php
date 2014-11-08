<?php
include "lib.php";
if (isset($_GET['logout'])) unset($_SESSION['username']);
private_zone();
?>
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
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
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
              <?=$_SESSION['username']?>
              <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?logout">Logout</a></li>
              </ul>
            </li>
        </div>
        <div class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<?php 
if ($_SESSION['download'] == 'ext') echo "Video Download"; 
else echo "m3u Download";
?>
              <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?download=m3u">m3u Download</a></li>
                <li><a href="index.php?download=ext">Video Download</a></li>
              </ul>
            </li>
        </div>
        <form class="navbar-form navbar-right">
        </form>
    </div>
</nav>
    <div class="page-header">
        <h1>Media Library <small>just a media library...</small></h1>
    </div>
<?php
empty_temp_files($temp_dir);
$files = glob("$root_dir/*");
$i = 0;
foreach($files as $file) {
    if (isset(pathinfo($file)['extension']))
        $ext = pathinfo($file)['extension'];
    else $ext ='';
    $film = "";
    if (!is_dir($file) and in_array($ext, $video_extension))
        $film = create_m3u_from_file($file, $temp_dir);
    if (is_dir($file))
        $film = create_m3u_from_dir($file, $temp_dir);
    if ($film == '') continue;
    if ($i % 4 == 0) echo "<div class='row'>";
    echo "<div class='col-md-3 col-sm-3'><div class='thumbnail'>";
    if ($_SESSION['download'] == 'm3u')
        echo "<a href='$film[link]'>";
    else echo "<a href='$film[stream]'>";
    echo "<img src='$film[image]' alt='$film[name]'>";
    echo "<div class='caption'>$film[name]</div>";
    echo "</div></div></a>";
    $i++;
    if ($i % 4 == 0) echo "</div>";
}

?>
</div>
</body>
</html>
