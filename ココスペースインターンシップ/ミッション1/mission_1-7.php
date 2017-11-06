<?php

//テキストファイルを読み込んで表示させる;

$fp = fopen("kadai6.txt",'r');  //txtファイルを読み込み用に開く

while ($line = fgets($fp)){
   echo "$line<br/>";
}

fclose($fp);

?>