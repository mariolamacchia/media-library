<?php
include "config.php";


function empty_temp_files($temp) {
    $files = glob($temp.'/*'); // get all file names
    foreach($files as $file){ // iterate files
        unlink($file); // delete file
    }
}

function create_m3u_from_file($file, $temp) {
        $actual_link = "http://$GLOBALS[ROOT_URI]";
        $filename = basename($file);
        $hash = md5($filename);
        symlink($file,'temp/'.$hash);
        $content = "#EXTM3U\n\n";
        $content .= "#EXTINF:-1, $filename\n";
        $content .= "$actual_link".str_replace(' ','%20',"temp/$hash");
        echo "<li><a href='$actual_link"."temp/$hash.m3u'>$filename</a><br></li>";
        File_put_contents('temp/'.$hash.'.m3u',$content);
}

function create_m3u_from_dir($dir, $temp) {
        $actual_link = "http://$GLOBALS[ROOT_URI]";
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

function private_zone() {
    session_start();
    if (!isset($_SESSION['username']))
        header("location: login.php");
}
function public_zone() {
    session_start();
    if (isset($_SESSION['username']))
        header("location: index.php");
}
?>
