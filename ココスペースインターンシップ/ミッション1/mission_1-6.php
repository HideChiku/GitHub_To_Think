<?php
$comment = $_GET['message'];

$comment = mb_convert_encoding($comment, "Shift_JIS", "HTML-ENTITIES");

$filename = 'kadai6.txt';

$fp = fopen($filename,'a');

fwrite($fp,"$comment"."\n");

?>