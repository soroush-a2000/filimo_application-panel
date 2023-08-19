<?php 
$media = $subtitle->getMedia();
$file_name = $media->getLink();
$result = file_get_contents($media->getLink());
header('Content-Type:text/vtt; charset=utf-8');
echo $result;
?>