<?php
if( ! empty($download_path))
{
    //$data = 'Here is some text!';
$data =  file_get_contents($download_path);
$name = $filename;

force_download($name, $data); 
 
}
?>

