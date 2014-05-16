<?php
$ROOT_DIR = "/var/media/videos";
$TEMP_DIR = "temp";
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

function empty_temp_files($temp) {
    $files = glob($temp.'/*'); // get all file names
    foreach($files as $file){ // iterate files
        unlink($file); // delete file
    }
}

function create_m3u_from_file($file, $temp) {
    $actual_link = $GLOBALS['actual_link'];
    $filename = basename($file);
    $hash = md5($filename);
    symlink($file,'temp/'.$hash);
    $content = "#EXTM3U\n\n";
    $content .= "#EXTINF:-1, $filename\n";
    $content .= "$actual_link".str_replace(' ','%20',"temp/$hash");
    echo "<li><a href='$actual_link"."temp/$hash.m3u'>$filename</a><br></li>";
    file_put_contents('temp/'.$hash.'.m3u',$content);
}

function create_m3u_from_dir($dir, $temp) {
    $actual_link = $GLOBALS['actual_link'];
    $dirname = basename($dir);
    $hash = md5($dirname);
    symlink($dir,"temp/$hash");
    $content = "#EXTM3U\n\n";
    $files = glob("$dir/*");
    foreach($files as $file) {
        $filename = basename($file);
        $content .= "#EXTINF:-1, $filename\n";
        $content .= "$actual_link".str_replace(' ','%20',"temp/$hash/$filename\n");
    }
    echo "<li><a href='$actual_link"."temp/$hash.m3u'>$dirname</a><br></li>";
    file_put_contents('temp/'.$hash.'.m3u',$content);
}

empty_temp_files($TEMP_DIR);
$files = glob("$ROOT_DIR/*");
echo "<h1>My Videos</h1>";
echo "<h2>My Movies</h2><ul>";
foreach($files as $file) 
    if (!is_dir($file))
        create_m3u_from_file($file, $TEMP_DIR);
echo "</ul><h2>My Fictions</h2><ul>";
foreach($files as $file)
    if (is_dir($file))
        create_m3u_from_dir($file, $TEMP_DIR);
echo "</ul>";

?>
