<?php

include "lib.php";
private_zone();

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
