<?php
include "config.php";
session_start();
if (isset($_GET['download'])) {
  $_SESSION['download'] = $_GET['download'];
  header("location: index.php");
} else if (!isset($_SESSION['download'])) $_SESSION['download'] = "m3u";

function empty_temp_files($temp) {
  /* Empty .tmp folder */

  // Get all file names
  $files = glob($temp.'/*');

  // Iterate and delete files
  foreach($files as $file){
    unlink($file);
  }
}

function create_m3u_from_file($file) {
  /* Get an input file, create and return a playlist m3u files containing it */

  $actual_link = "http://$GLOBALS[root_uri]";
  $temp = $GLOBALS['temp_dir'];
  $filename = basename($file);
  $hash = md5($filename);
  symlink($file,'temp/'.$hash);

  // Create text to write into m3u file
  $content = "#EXTM3U\n\n";
  $content .= "#EXTINF:-1, $filename\n";
  $content .= "$actual_link".str_replace(' ','%20',"temp/$hash");

  // Look for an image
  $image = '';
  $s = dirname($file).'/'.pathinfo($file)['filename'].'*';
  $images = glob($s) ;
  foreach($images as $imgfile) {
    if (in_array(pathinfo($imgfile)['extension'], 
      $GLOBALS['images_extension']))
      $image = $imgfile;
  }
  if ($image == '') $image = $GLOBALS['default_movie_img'];
  else {
    // Make symlink
    $imgext = pathinfo($image)['extension'];
    symlink($image, "temp/$hash.$imgext");
    $image = "temp/$hash.$imgext";
  }

  // Output
  $ret = array(
    'link' => $actual_link."temp/$hash.m3u",
    'image' => $image,
    'name' => basename($filename, '.'.pathinfo($file)['extension']),
    'stream' => $actual_link."temp/$hash",
  ); 
  file_put_contents('temp/'.$hash.'.m3u',$content);
  return $ret;
}

function create_m3u_from_dir($dir) {
  /* Get an input folder, create and return a m3u file with all
   * files in the folder                                        */

  $actual_link = "http://$GLOBALS[root_uri]";
  $temp = $GLOBALS['temp_dir'];
  $dirname = basename($dir);
  $hash = md5($dirname);
  symlink($dir,"temp/$hash");
  $content = "#EXTM3U\n\n";
  $files = glob("$dir/*");
  foreach($files as $file) {
    $filename = basename($file);
    $content .= "#EXTINF:-1, $filename\n";
    $content .= "$actual_link".str_replace
      (' ','%20',"temp/$hash/$filename\n");
  }

  // Look for an image
  $images = glob("$dir*");
  $image = '';
  foreach($images as $imgfile) {
    if (!is_dir($imgfile)) 
      if (in_array(pathinfo($imgfile)['extension']
        ,$GLOBALS['images_extension']))
        $image = $imgfile;
  }
  if ($image == '') $image = $GLOBALS['default_folder_img'];
  else {
    // Make symlink
    $imgext = pathinfo($image)['extension'];
    symlink($image, "temp/$hash.$imgext");
    $image = "temp/$hash.$imgext";
  }

  // Output
  $ret = array(
    'link' => $actual_link."temp/$hash.m3u",
    'image' => $image,
    'name' => $dirname,
    'stream' => $actual_link."temp/$hash.m3u",
  );
  file_put_contents('temp/'.$hash.'.m3u',$content);
  return $ret;
}

function private_zone() {
  if (!isset($_SESSION['username']))
    header("location: login.php");
}
function public_zone() {
  if (isset($_SESSION['username']))
    header("location: index.php");
}
?>
