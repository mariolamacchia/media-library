<?php
// Folder where to place all media
$root_dir = "/var/media/videos";
// Folder where all .m3u files will be stored
$temp_dir = "temp";
// Url of your service
$root_uri = "mariolamacchia.com/videos/";

// Login username
$username = "admin";
// md5 encrypted password (default is 'password')
$password = "5f4dcc3b5aa765d61d8327deb882cf99";

// If no image related to eather a file or a folders is found,
// these will be used
$default_movie_img = "images/movie.ico";
$default_folder_img = "images/folder.png";

// Supported image extensions
$images_extension = array(
    'ico', 'png', 'jpg', 'jpeg'
);

// Supported video extensions
$video_extension = array(
    'mp4', 'mov', 'avi', 'mkv', '3gp',
    'wmv', 'mka', 'flac', 'aac', 'vid',
);
?>
