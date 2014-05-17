<?php

include "lib.php";
private_zone();

empty_temp_files($temp_dir);
$files = glob("$root_dir/*");
echo "<h1>My Videos</h1>";
foreach($files as $file) {
    if (isset(pathinfo($file)['extension']))
        $ext = pathinfo($file)['extension'];
    else $ext ='';
    if (!is_dir($file) and in_array($ext, $video_extension))
        create_m3u_from_file($file, $temp_dir);
    if (is_dir($file))
        create_m3u_from_dir($file, $temp_dir);
}
echo "</ul>";

?>
