<?php

include "lib.php";
private_zone();

empty_temp_files($TEMP_DIR);
$files = glob("$ROOT_DIR/*");
echo "<h1>My Videos</h1>";
foreach($files as $file) {
    if (isset(pathinfo($file)['extension']))
        $ext = pathinfo($file)['extension'];
    else $ext ='';
    if (!is_dir($file) and in_array($ext, $VIDEO_EXTENSION))
        create_m3u_from_file($file, $TEMP_DIR);
    if (is_dir($file))
        create_m3u_from_dir($file, $TEMP_DIR);
}
echo "</ul>";

?>
