<?php

die();

$max_size_file = get_cfg_var('upload_max_filesize');
$max_size_file_int =(int)$max_size_file;

var_dump($max_size_file, $max_size_file_int);
//phpinfo();

?>