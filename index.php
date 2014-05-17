<!DOCTYPE html>
<html>
<head>
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
        <h1>Video Server <small>just a video server...</small></h1>
    </div>
<?php

include "lib.php";
private_zone();

empty_temp_files($temp_dir);
$files = glob("$root_dir/*");
echo "<h1>My Videos</h1>";
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
    echo "<div class='col-md-3'><div class='thumbnail'>";
    echo "<a href='$film[link]'>";
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
