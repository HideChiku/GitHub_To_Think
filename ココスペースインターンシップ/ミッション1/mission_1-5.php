<?php
$comment = $_GET['message'];

$comment = mb_convert_encoding($comment, "Shift_JIS", "HTML-ENTITIES");

$filename = 'kadai5.txt';

$fp = fopen($filename,'w');

fwrite($fp,"$comment");

fclose($fp)

?>